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

<div class="container-fluid ml-1">

    <div class="d-flex align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['user/create'], [
            'class' => 'btn',
            'title' => 'Create User',
            'style' => 'color: green; text-decoration: none; margin-right: 10px; margin-left: 15px;',
        ]) ?>
    </div>
    <div class="row">
        <div class="col-6 float-left">
            <h6 class="float-left">
                <p class="float-left"><i class="fa-regular fa-circle-xmark" style="color: #dc3545;"></i> - Disabled User </p><br>
                <p class="float-left"><i class="fa-regular fa-circle-check" style="color: #28a745;"></i> - Enabled User </p>
            </h6>
        </div>
        <div class="col-6 float-right">
            <h6 class="float-right">
                <p class="float-right"><i class="fa fa-pen " style="color: #28a745;"></i> - Edit User &emsp;</p>
                <p class="float-right"><i class="fa fa-eye " style="color: #007bff;"></i> - Master Detail &emsp;&emsp;</p><br>
                <p class="float-right"><i class="fa fa-ban" style="color: #000000;"></i> - Ban/Unban User &emsp;</p>
                <p class="float-right"><i class="fa fa-redo" style="color: #ffcc00;"></i> - Enable User &emsp;</p>
                <p class="float-right"><i class="fa fa-trash" style="color: #dc3545;"></i> - Desable User &emsp;</p>
            </h6>
        </div>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'username',
            [
                'attribute' => 'name',
                'format' => 'raw',
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

                    $stationDisplay = $stationName ? " ({$stationName})" : '';
                    $icon = $model->userInfo->is_deleted
                        ? Html::tag('i', '', ['class' => 'fa-regular fa-circle-xmark', 'aria-hidden' => 'true', 'style' => 'color: #dc3545'])
                        : Html::tag('i', '', ['class' => 'fa-regular fa-circle-check', 'aria-hidden' => 'true', 'style' => 'color: #28a745']);

                    return "{$icon} {$userName}{$stationDisplay}";
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

                    $currentUserRoles = $authManager->getRolesByUser(Yii::$app->user->id);
                    $currentUserRole = reset($currentUserRoles);

                    if ($currentUserRole && $currentUserRole->name === 'Manager') {
                        $roles = array_filter($roles, function ($role) {
                            return in_array($role->name, ['Incharge', 'Employee']);
                        });
                    } elseif ($currentUserRole && $currentUserRole->name === 'Incharge') {
                        $roles = array_filter($roles, function ($role) {
                            return $role->name === 'Employee';
                        });
                    }

                    if ($model->id == Yii::$app->user->id || $model->userInfo->is_deleted == 1 || $model->userInfo->is_banned == 1) {
                        return $currentRole ? $currentRole->name : 'N/A';
                    }

                    $dropdown = Html::dropDownList(
                        "role_{$model->id}",
                        $currentRole ? $currentRole->name : null,
                        \yii\helpers\ArrayHelper::map($roles, 'name', 'name'),
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
        'summary' => false,
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