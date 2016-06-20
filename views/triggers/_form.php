<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Triggers */
/* @var $form yii\widgets\ActiveForm */
?>
<head>
    <script>
        function showAvailableEvents(str) {
            document.getElementById("triggers-eventcode").innerHTML="";
            if (str==="") {

                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            //монструозная конструкция url чтоб работало и в create, и в update
            xmlhttp.open("GET",document.documentURI.substr(0, document.documentURI.search('triggers')+8)+"/events?by="+str,false);
            xmlhttp.send();
            if (xmlhttp.status != 200) {
                // обработать ошибку
                alert( xmlhttp.status + ': ' + xmlhttp.statusText ); // пример вывода: 404: Not Found
            } else {
                // вывести результат
                //alert( xmlhttp.responseText ); // responseText -- текст ответа.
                //alert(xmlhttp.responseText);
                var arr = xmlhttp.responseText.split(',');
                for (i in arr) document.getElementById("triggers-eventcode").options[document.getElementById("triggers-eventcode").options.length] = new Option(arr[i], arr[i]);

            }
        }
        function showAvailableFields(str) {
            if (str==="") {
                document.getElementById("availableFields").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.open("GET",document.documentURI.substr(0, document.documentURI.search('triggers')+8)+"/fields?by="+str,false);
            xmlhttp.send();
            if (xmlhttp.status != 200) {
                // обработать ошибку
                alert( xmlhttp.status + ': ' + xmlhttp.statusText ); // пример вывода: 404: Not Found
            } else {
                // вывести результат
                //alert( xmlhttp.responseText ); // responseText -- текст ответа.
                //alert(document.getElementById("triggers-eventcode").options.length);
                document.getElementById("availableFields").innerHTML=xmlhttp.responseText;
            }
        }
    </script>
    <?php $this->head() ?>
</head>
<div class="triggers-form">

    <?php $userList=ArrayHelper::map(\app\models\User::find()->all(), 'id', 'nameAdress'); //список пользователей для выпадающего списка в виде емейл-адресов
    $adminList=ArrayHelper::map(\app\models\User::find()->where(['role'=>1])->all(), 'id', 'nameAdress');
    $adminList[0]='All';
    $adminList['{id}']='Initiator';//инициатору события
    $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model')->dropDownList(['User'=>'User','Articles'=>'Articles'],['prompt'=>'-Model to search-',
        'onchange'=>'showAvailableFields(this.value); showAvailableEvents(this.value)']) ?>

    <?= $form->field($model, 'eventCode')->dropDownList([$model::EVENT_AFTER_INSERT=>'After Insert', $model::EVENT_AFTER_UPDATE=>'After Update',$model::EVENT_AFTER_DELETE=>'After Delete']) ?>

    <?= $form->field($model, 'from')->dropDownList($userList) ?>

    <?= $form->field($model, 'to')->dropDownList($adminList) ?>

    <div class="alert">
        <h5>Available Parameters to use in text:</h5>
        <div class="alert-success" id="availableFields"></div>
    </div>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->checkboxList(['email'=>'email', 'browser'=>'browser']) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <script>
        var str=document.getElementById('triggers-model').value;
        showAvailableFields(str)
    </script>
</div>
