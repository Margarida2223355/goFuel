<?php

namespace app\models;

use common\models\Station;
use common\models\StationUser;
use common\models\User;
use common\models\UserInfo;
use Yii;
use yii\base\Model;

class UserForm extends Model
{
    public $username = '';
    public $email = '';
    public $nif = '';
    public $name = '';
    public $address = '';
    public $postal_code = '';
    public $role = '';
    public $phone = '';
    public $id = '';
    public $station_id = '';

    private $_user;
    private $_userInfo;

    /*public function __construct(User $user, UserInfo $userInfo, $config = [])
    {
        if ($user === null) {
            $this->_user = new User();
        } else {
            $this->_user = $user;
            $this->username = $user->username;
            $this->email = $user->email;
        }

        if ($userInfo === null) {
            $this->_userInfo = new UserInfo();
        } else {
            $this->_userInfo = $userInfo;
            $this->nif = $userInfo->nif;
            $this->name = $userInfo->name;
            $this->address = $userInfo->address;
            $this->postal_code = $userInfo->postal_code;
            $this->role = $userInfo->role;
        }

        parent::__construct($config);
    }*/


    public function rules()
    {
        return [
            [['username', 'email', 'nif', 'name', 'address', 'postal_code', 'role', 'phone'], 'required'],
            ['email', 'email'],
            [['nif', 'station_id'], 'integer'], // Adicione station_id como integer
            [['username', 'email', 'name', 'address'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 20],
            [['role'], 'in', 'range' => ['Admin', 'Manager', 'In Charge', 'Employee']],
            [['phone'], 'string', 'max' => 13],
            ['role', 'in', 'range' => $this->getAvailableRoles(), 'message' => 'Você não tem permissão para atribuir esta role.'],
        ];
    }

    public function getAvailableRoles()
    {
        $allRoles = [
            'Admin' => 'Admin',
            'Manager' => 'Manager',
            'In Charge' => 'In Charge',
            'Employee' => 'Employee',
        ];

        if (Yii::$app->user->can('Admin')) {
            $roles = $allRoles;
        } elseif (Yii::$app->user->can('Manager')) {
            $roles = array_filter($allRoles, fn($role) => in_array($role, ['In Charge', 'Employee']));
        }
        return $roles;
    }

    public function getIsNewRecord()
    {
        return empty($this->username);
    }

    public function save()
    {
        // Verifica se os dados são válidos
        if (!$this->validate()) {
            return false;
        }

        $this->_user = new User();
        $this->_userInfo = new UserInfo();

        $this->_user->id = $this->id;
        $this->_user->username = $this->username;
        $this->_user->email = $this->email;
        $this->_user->auth_key = \Yii::$app->security->generateRandomString();
        $this->_user->setPassword('password');
        $this->_user->generateEmailVerificationToken();
        $this->_user->status = 10;
        $this->_user->created_at = time();
        $this->_user->updated_at = time();

        if ($this->_user->save()) {
            $this->_userInfo->user_id = $this->_user->id;
            $this->_userInfo->nif = $this->nif;
            $this->_userInfo->name = $this->name;
            $this->_userInfo->address = $this->address;
            $this->_userInfo->postal_code = $this->postal_code;
            $this->_userInfo->phone = $this->phone;

            if ($this->_userInfo->save()) {
                if (!empty($this->station_id)) {
                    $stationUser = new StationUser();
                    $stationUser->user_id = $this->_user->id;
                    $stationUser->station_id = $this->station_id;

                    if (!$stationUser->save()) {
                        Yii::error('Falha ao salvar a associação entre o usuário e a estação: ' . json_encode($stationUser->getErrors()), __METHOD__);
                    }
                }

                $auth = Yii::$app->authManager;
                $role = $auth->getRole($this->role);
                if ($role) {
                    $auth->assign($role, $this->_user->id);
                }

                $this->id = $this->_userInfo->id;

                if ($this->role !== 'Admin' || $this->role !== 'Manager') {
                    $this->stationConnection();
                }
                return true;
            } else {
                Yii::error('Falha ao salvar UserInfo: ' . json_encode($this->_userInfo->getErrors()), __METHOD__);
            }
        } else {
            Yii::error('Falha ao salvar User: ' . json_encode($this->_user->getErrors()), __METHOD__);
        }

        return false;
    }

    public function stationConnection()
    {
        switch ($this->role) {
            case 'In Charge':
            case 'Employee':
                $stationUser = new StationUser();

                $stationUser->station_id = $this->station_id;
                $stationUser->user_id = $this->id;

                $stationUser->save();
                break;
            default:
                echo "fail";
                die;
                break;
        }
    }

    public function loadUser($user)
    {
        $this->username = $user->username;
        $this->email = $user->email;
    }

    public function loadUserInfo($userInfo)
    {
        $this->name = $userInfo->name;
        $this->nif = $userInfo->nif;
        $this->address = $userInfo->address;
        $this->postal_code = $userInfo->postal_code;
        $this->phone = $userInfo->phone;

        // Atribuir o user_id explicitamente
        $this->id = $userInfo->user_id;
    }

    public function userAttributes()
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            // 'password' => $this->password,
        ];
    }

    public function userInfoAttributes()
    {
        return [
            'user_id' => $this->id,
            'name' => $this->name,
            'nif' => $this->nif,
            'role' => $this->role,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
        ];
    }
}
