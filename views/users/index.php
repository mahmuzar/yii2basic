<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\widgets\ListView;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Управление пользователями системы';
$this->params['breadcrumbs'][] = $this->title;

/*
  echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_list',
  'layout' => "{pager}\n{summary}\n{items}\n{pager}",
  ]);

 */
?>
<div class="update">
    <?php
    echo $this->render('_alert');
    GridView::begin([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'username',
            'email',
            'date_registration',
            'date_of_last_authorization',
            'role',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model, $key) {

                        return Html::a('', '#'.$model->id, [
                                    'class' => ['glyphicon', 'glyphicon-pencil', 'update_user']
                                        ]
                        );
                    },
                ],
            // you may configure additional properties here
            ],
        ]
    ]);
    GridView::end();
    echo $this->render('_add_user_modal', ['model' => $model]);
    echo $this->render('_update_user_modal', ['model' => $model]);
    ?>
</div>
