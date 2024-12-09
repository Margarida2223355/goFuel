<?php

use common\models\User;
use hail812\adminlte\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid ml-1">
    <?php
    $alert = Yii::$app->session->get('alert');
    if ($alert) {
        echo Alert::widget([
            'type' => $alert['type'],
            'body' => "<strong>{$alert['title']}</strong><br> {$alert['message']}",
        ]);

        Yii::$app->session->remove('alert');
    }
    ?>

    <div class="d-flex align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['user/create'], [
            'class' => 'btn',
            'title' => 'Create User',
            'style' => 'color: green; text-decoration: none; margin-right: 10px; margin-left: 15px;',
        ]) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'username',
            [
                'label' => 'Nome',
                'value' => function ($model) {
                    $userName = $model->userInfo ? $model->userInfo->name : 'N/A';
                    $stationName = null;

                    if ($model->stationUsers) {
                        $station = $model->stationUsers->station;
                        $stationName = $station ? $station->name : null;
                    } elseif ($model->stations) {
                        $stationNames = array_map(fn($station) => $station->name, $model->stations);
                        $stationName = implode(', ', $stationNames);
                    }
                    return $stationName ? "{$userName} ({$stationName})" : $userName;
                },
            ],
            'email',
            [
                'label' => 'Role',
                'format' => 'raw',
                'value' => function ($model) {
                    $authManager = Yii::$app->authManager;
                    $roles = $authManager->getRoles();
                    $userRole = $authManager->getRolesByUser($model->id);
                    $currentRole = reset($userRole);
                    if ($model->id == Yii::$app->user->id || $model->userInfo->is_deleted ==1 || $model->userInfo->is_banned == 1) {
                        return $currentRole ? $currentRole->name : 'N/A';
                    }
                    $dropdown = Html::dropDownList(
                        "role_{$model->id}",
                        $currentRole ? $currentRole->name : null,
                        array_map(fn($role) => $role->name, $roles),
                        [
                            'class' => 'form-control role-selector',
                            'data-id' => $model->id,
                        ]
                    );
                    return $dropdown;
                },
            ],

            [
                'class' => ActionColumn::class,
                'header' => 'Actions',
                'template' => '{view} {update} {reset-password} {delete} {ban}',
                'buttons' => [
                    'reset-password' => function ($url, $model) {
                        if ($model->id != Yii::$app->user->id) {
                            if ($model->userInfo->is_banned == false) {
                                return Html::a('<i class="fa fa-lock" aria-hidden="true"></i>', $url, [
                                    'title' => 'Reset password',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Tem certeza que deseja redefinir a senha para o padrão?',
                                    'style' => 'color: #ffcc00; text-decoration: none;',
                                ]);
                            }
                        }
                    },
                    'view' => function ($url, $model) {
                        if ($model->userInfo->is_banned == false) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', $url, [
                                'title' => 'Vew detsails',
                                'style' => 'color: #007bff; text-decoration: none;',
                            ]);
                        }
                    },
                    'update' => function ($url, $model) {
                        if ($model->id == Yii::$app->user->id) {
                            if ($model->userInfo->is_banned == false) {
                                return Html::a('<i class="fa fa-pen" aria-hidden="true"></i>', $url, [
                                    'title' => 'Update',
                                    'style' => 'color: #28a745; text-decoration: none;',
                                ]);
                            }
                        }
                        return '';
                    },
                    'delete' => function ($url, $model) {
                        if ($model->id != Yii::$app->user->id) {
                            if ($model->userInfo->is_banned == false) {
                                if ($model->userInfo->is_deleted == false) {
                                    return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', $url, [
                                        'title' => 'Desable',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Confirm User Disablement?',
                                        'style' => 'color: #dc3545; text-decoration: none;',
                                    ]);
                                } else {
                                    return Html::a('<i class="fa fa-redo" aria-hidden="true"></i>', $url, [
                                        'title' => 'Enable',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Confirm User Enablement?',
                                        'style' => 'color: #ffcc00; text-decoration: none;',
                                    ]);
                                }
                            }
                        }
                    },
                    'ban' => function ($url, $model) {
                        if ($model->id != Yii::$app->user->id) {
                            if ($model->userInfo->is_deleted == false) {
                                if ($model->userInfo->is_banned == false) {
                                    return Html::a('<i class="fa fa-ban" aria-hidden="true"></i>', $url, [
                                        'title' => 'Ban',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Tem certeza que deseja deletar este usuário?',
                                        'style' => 'color: #000000; text-decoration: none;',
                                    ]);
                                } else {
                                    return Html::a('<i class="fa fa-ban" aria-hidden="true"></i>', $url, [
                                        'title' => 'Unban',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Tem certeza que deseja deletar este usuário?',
                                        'style' => 'color: #000000; text-decoration: none;',
                                    ]);
                                }
                            }
                        }
                    },
                ],
            ],


        ],
    ]); ?>
</div>

<?php
$script = <<<JS
$('.role-selector').on('change', function () {
    const userId = $(this).data('id');
    const newRole = $(this).val();
    $.ajax({
        url: 'changerole',
        type: 'POST',
        data: {
            user_id: userId,
            role: newRole,
            _csrf: yii.getCsrfToken(),
        },
        success: function () {
            location.reload();
        },
        error: function () {
            alert('Erro ao atualizar a role.');
        }
    });
});
JS;
$this->registerJs($script);
?>