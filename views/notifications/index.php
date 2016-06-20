<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\bootstrap\Alert;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<head>
    <script>
        function dismiss(notifId) {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.open("GET",document.documentURI.substr(0, document.documentURI.search('notifications')+13)+"/dismiss?id="+notifId, true);
            xmlhttp.send();
        }
    </script>
    <?php $this->head() ?>
</head>
<div class="notifications-index">

    <h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => function ($model, $key, $index, $widget) {
            return Alert::widget([
                'options' => [
                    'class' => 'alert-'.((0==$model->dismissed)?'danger':'success')
                ],
                'closeButton' =>['onclick'=>'this.parentElement.className="alert-success alert fade in"; dismiss("'.$model->id.'")', 'data-dismiss'=>'no'],
                'body' => $model->date.' FROM: <b>'.\app\models\User::findOne(['id'=>$model->from])->name.'<br/>'.$model->title .'</b> '.$model->body
            ]);
            //Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
        },
    ]) ?>
<?php Pjax::end(); ?></div>
