<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Triggers */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Triggers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="triggers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'model',
            'eventCode',
            'from',
            'to',
            'title',
            'type',
            'body:ntext',
        ],
    ]) ?>

</div>
