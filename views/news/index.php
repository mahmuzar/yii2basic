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
use yii\helpers\Url;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\Button;

$this->title = 'Новсти';
$this->params['breadcrumbs'][] = $this->title;

/*
  echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_list',
  'layout' => "{pager}\n{summary}\n{items}\n{pager}",
  ]);

 */
?>

<div class="news">

    <?php
    echo ButtonGroup::widget(
            ['buttons' => [
                    Html::a('5', Url::current(['pageSize' => 5]), ['class' => 'btn btn-default btn-sm']),
                    Html::a('10', Url::current(['pageSize' => 10]), ['class' => 'btn btn-default btn-sm']),
                    Html::a('20', Url::current(['pageSize' => 20]), ['class' => 'btn btn-default btn-sm']),
                    Html::a('30', Url::current(['pageSize' => 30]), ['class' => 'btn btn-default btn-sm']),
                ]
    ]);
    GridView::begin([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'logo',
                'value' => function($model) {
                    return Html::img('@web/uploads/' . $model->logo, [
                                'class' => 'img-thumbnail',
                                'style' => 'height: 60px;',
                                    ]
                    );
                },
                'format' => 'html'
            ],
            'title',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'content',
                'value' => function($model) {
                    return mb_substr(strip_tags($model->content), 0, 20) . '...';
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'status',
                'value' => function($model) {
                    if ($model->status == 0) {
                        return Html::a('inactive', '#'.$model->id, [
                                    'class' => ['btn btn-danger status']
                        ]);
                    }
                    return Html::a('active', '#'.$model->id, [
                                'class' => ['btn btn-success status']
                    ]);
                },
                'format' => 'html'
            ],
            'date',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'delete' => function($url, $model, $key) {
                        if ((Yii::$app->user->getId() == $model->user_id) || (Yii::$app->user->getIdentity()->role >= 30)) {

                            return Html::a('', $url, [
                                        'id' => 'id' . $key,
                                        'class' => ['glyphicon glyphicon-trash'],
                                        'data' => ['pjax' => 0],
                                        'data-id' => $key,
                                            ]
                            );
                        }
                        return '';
                    },
                    'update' => function($url, $model, $key) {
                        if ((Yii::$app->user->getId() == $model->user_id) || (Yii::$app->user->getIdentity()->role >= 30)) {

                            return Html::a('', '#'.$model->id, [
                                        'id' => 'id' . $key,
                                        'class' => ['glyphicon glyphicon-pencil update_news']
                                            ]
                            );
                        }
                        return '';
                    },
                ]
            ]]
    ]);
    GridView::end();
    echo $this->render('_add_news', ['model' => $model]);
    echo $this->render('_update_news_modal', ['model' => $model]);
    ?>
</div>
<?php

