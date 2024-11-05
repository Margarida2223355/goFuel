<?php

namespace app\models;

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
    public $phone = 0;
    public $id = 0;
    public $station_id;

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
            [['nif'], 'integer', 'min' => 9],
            [['username', 'email', 'name', 'address'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 20],
            [['role'], 'in', 'range' => ['Admin', 'Manager', 'In Charge', 'Employee']],
            [['phone'], 'string', 'max' => 13],
            ['role', 'in', 'range' => $this->getAvailableRoles(), 'message' => 'Você não tem permissão para atribuir esta role.'],

        ];
    }
    public function getAvailableRoles()
    {
        $roles = [];
        if (Yii::$app->user->can('Admin')) {
            $roles = ['Admin' => 'Admin', 'Manager' => 'Manager'];
        } elseif (Yii::$app->user->can('Manager')) {
            $roles = ['In Charge' => 'In Charge', 'Employee' => 'Employee'];
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

        // Verifica se a role é permitida
        /*if (!in_array($this->role, array_keys($this->getAvailableRoles()))) {
            $this->addError('role', 'Você não tem permissão para atribuir esta role.');
            return false;
        }*/

        $this->_user = new User();
        $this->_userInfo = new UserInfo();

        $this->_user->username = $this->username;
        $this->_user->email = $this->email;
        $this->_user->auth_key = \Yii::$app->security->generateRandomString();
        $this->_user->setPassword('password');
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
                return true;
            } else {
                Yii::error('Falha ao salvar UserInfo: ' . json_encode($this->_userInfo->getErrors()), __METHOD__);
            }
        } else {
            Yii::error('Falha ao salvar User: ' . json_encode($this->_user->getErrors()), __METHOD__);
        }

        return false;
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
            'name' => $this->name,
            'nif' => $this->nif,
            'role' => $this->role,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
        ];
    }
}
