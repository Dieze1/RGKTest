<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Triggers */

$this->title = 'Create Triggers';
$this->params['breadcrumbs'][] = ['label' => 'Triggers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="triggers-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
