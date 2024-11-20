<?php

namespace frontend\controllers;

use common\models\ClientStation;
use common\models\Invoice;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Station;
use common\models\User;
use common\models\UserInfo;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionIndex()
    {
        $currentUser = Yii::$app->user->identity;
        if ($currentUser) {
            $starredStation = ClientStation::findOne(['client_id' => $currentUser->id]);

            if ($starredStation) {
                $station = Station::findOne($starredStation->station_id);
            } else {
                $station = null;
            }

            $userInvoices = Invoice::find(['client_id' => $currentUser->id, 'state_id' != 1])->all();

            return $this->render('index', ['station' => $station, 'invoices' => $userInvoices]);
        } else {
            $station = null;
            $userInvoices = null;
            return $this->render('index', ['station' => $station, 'invoices' => $userInvoices]);
        }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $model->load(Yii::$app->request->post());
        if (/*$model->load(Yii::$app->request->post()) &&*/$model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->redirect(['about']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionProfile($id)
    {
        $user = User::findOne($id);
        if ($user === null) {
            throw new NotFoundHttpException('Usuário não encontrado.');
        }

        $userInfo = UserInfo::findOne(['user_id' => $user->id]);
        if ($userInfo === null) {
            throw new NotFoundHttpException('Informações do usuário não encontradas.');
        }

        $model = new SignupForm();
        $model->username = $user->username;
        $model->email = $user->email;
        $model->nif = $userInfo->nif;
        $model->name = $userInfo->name;
        $model->address = $userInfo->address;
        $model->postal_code = $userInfo->postal_code;
        $model->phone = $userInfo->phone;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->username = $model->username;
            $user->email = $model->email;
            if (!$user->save()) {
                Yii::$app->session->setFlash('error', 'Falha ao atualizar o usuário: ' . json_encode($user->getErrors()));
                return $this->refresh();
            }

            $userInfo->nif = $model->nif;
            $userInfo->name = $model->name;
            $userInfo->address = $model->address;
            $userInfo->postal_code = $model->postal_code;
            $userInfo->phone = $model->phone;

            if ($userInfo->save()) {
                Yii::$app->session->setFlash('success', 'Dados atualizados com sucesso.');
                return $this->redirect(['profile', 'id' => $user->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Falha ao atualizar as informações do usuário: ' . json_encode($userInfo->getErrors()));
            }
        }
        return $this->render('profile', [
            'model' => $model,
            'user' => $user,
        ]);
    }


    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
