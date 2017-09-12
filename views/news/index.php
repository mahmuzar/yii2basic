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
<style>
   
</style>
<div class="news">
    <?php
    GridView::begin([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'logo',
                'value' => function($model) {
                    return Html::img('@web/uploads/' . $model->logo,[
                        'class'=>'img-thumbnail',
                        'style'=>'height: 60px;',
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
                    return mb_substr($model->content, 0, 20) . '...';
                }
            ],
            'status',
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

                            return Html::a('', $url, [
                                        'id' => 'id' . $key,
                                        'class' => ['glyphicon glyphicon-pencil'],
                                        'data' => ['pjax' => 0],
                                        'data-update_news_id' => $key,
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
<script>
    function checkStatus(e) {
        console.log(e);
        alert('d');
    }
</script>