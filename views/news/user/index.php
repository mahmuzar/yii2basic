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
                        'style'=>'width: 100px;',
                        ]
                            );
                },
                'format' => 'html'
            ],
            'title',
            ['attribute' => 'content',
                'value' => function($model) {
                    return mb_substr($model->content, 0, 20) . '...';
                },
                'format'=>'html'
            ],
            'date',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'delete' => function () {
                        
                    },
                    'update' => function() {
                        
                    },
                    
                            
                ],
            ]]
    ]);
    GridView::end();
    ?>
</div>