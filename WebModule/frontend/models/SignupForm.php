<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\UserInfo;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username = '';
    public $email = '';
    public $password = '';
    public $nif = '';
    public $name = '';
    public $address = '';
    public $postal_code = '';
    public $phone = 0;
    public $id = 0;

    private $_user;
    private $_userInfo;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['username', 'email', 'nif', 'name', 'address', 'postal_code', 'phone'], 'required'],
            ['email', 'email'],
            [['nif'], 'integer', 'min' => 9],
            [['username', 'email', 'name', 'address'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 20],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            [['phone'], 'string', 'max' => 13],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->_user = new User();
        $this->_userInfo = new UserInfo();

        $this->_user->username = $this->username;
        $this->_user->email = $this->email;
        $this->_user->auth_key = \Yii::$app->security->generateRandomString();
        $this->_user->setPassword($this->password);
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
                $auth = \Yii::$app->authManager;
                $clientRole = $auth->getRole('Client');
                $auth->assign($clientRole, $this->_user->getId());
            } else {
                Yii::error('Falha ao salvar UserInfo: ' . json_encode($this->_userInfo->getErrors()), __METHOD__);
            }
        }

        return $this->_user->save();
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
