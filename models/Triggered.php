<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 15.06.2016
 * Time: 1:56
 */

namespace app\models;
use yii;
use yii\base\Behavior;


/**
 * Поведение, прикручиваемое к отслеживаемым моделям.
 */
class Triggered extends Behavior
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        $evs = $this->owner->getEvents();
        $ret = array();
        foreach ($evs as $ek=>$ev) $ret[$ev] = 'triggerMe';
        return $ret;
    }

    /**Функция, которая выполняется при срабатывании всех доступных событий подключаемых моделей
     * @param $event
     */
    public function triggerMe($event )
    {
        //сначала выбираем из БД триггеры для сработавшего события и модели
        foreach (Triggers::find()->where(['model'=>$this->owner->className()])->where(['eventCode'=>$event->name])->each() as $trigger){
            //типы уведомлений в триггере - в массив
            $types = explode(',', $trigger->type);
            //разбираемся с разными вариантами адресатов уведомлений
            //Инициатору события            
            if ($trigger->to=='{id}') $to=[0=>(isset(Yii::$app->user->identity))?(Yii::$app->user->identity->getId()):$this->owner->id];
            //всем
            elseif ($trigger->to==0) $to=yii\helpers\ArrayHelper::map(User::find()->all(), 'id', 'id');
            //одному
            else $to=[0=>$trigger->to];
            //ищем в массиве выбранных типов уведомлений поддерживаемые и выполняем
            if (array_search('browser', $types)!==false) {
                
                $attrs=[
                    'date' => date('Y-m-d', time()),
                    'body' => Yii::t('app', $trigger->body, yii\helpers\ArrayHelper::toArray($this->owner)),
                    'dismissed' => 0,
                    'from' => $trigger->from,
                    'title' => Yii::t('app', $trigger->title, yii\helpers\ArrayHelper::toArray($this->owner)),
                    'trigger_id' => $trigger->id,
                ];
                foreach ($to as $t){//пробегаем массив адресатов
                    $attrs['to'] = $t;
                    $notification = new Notifications();
                    $notification->attributes = $attrs;
                    $notification->save();//создаем новое браузерное уведомление
                }
            } elseif (array_search('email', $types)!==false){
                foreach ($to as $t) {//пробегаем массив адресатов
                    $ret = User::find()->where(['id' => $t])->addSelect('email')->asArray()->one();
                    Yii::$app->mailer->setBody(Yii::t('app', $trigger->body, yii\helpers\ArrayHelper::toArray($this->owner)))
                        ->setFrom('from@domain.com')
                        ->setTo($ret['email'])
                        ->setSubject(Yii::t('app', $trigger->title, yii\helpers\ArrayHelper::toArray($this->owner)))
                        ->send();//уведомление на электронную почту
                }
            }
        }

    }
}