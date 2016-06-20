<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 12.06.2016
 * Time: 16:01
 */
?>
<h1>Регистрация</h1>
<?php
use \yii\widgets\ActiveForm;
?>
<?php
    $form = ActiveForm::begin(['class'=>'form-horizontal']);
?>

<?= /** @var \app\models\Signup $model */
$form->field($model,'email')->textInput(['autofocus'=>true]) ?>

<?= $form->field($model,'name')->textInput() ?>

<?= $form->field($model,'password')->passwordInput()?>

<?= $form->field($model,'role')->dropDownList(['0'=>'User', '1'=>'Admin'])?>

    <div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

<?php
    ActiveForm::end();
?>