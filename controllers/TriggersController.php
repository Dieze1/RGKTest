<?php

namespace app\controllers;

use Yii;
use app\models\Triggers;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TriggersController implements the CRUD actions for Triggers model.
 */
class TriggersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Triggers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Triggers::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Triggers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Triggers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Triggers();
        $post=Yii::$app->request->post();
        if (isset($post['Triggers'])) {
            //$post['Triggers']['type']=implode(';',$post['Triggers']['type']);//склеиваем выбранные типы уведомлений в строку
            $model->attributes=$post['Triggers'];
            if(isset($post['Triggers']['type']) && $post['Triggers']['type']!==array())
                $model->type=implode(',',$post['Triggers']['type']);
        //var_dump($post)
            if ($model->save()) return $this->redirect(['view', 'id' => $model->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Возвращает доступные аттрибуты выбранной модели
     * @return string
     */
    public function actionFields()
    {
        $by= $_GET['by'];
        $html = '';
        $className = 'app\models\\'.$by;
        $model = new $className();
        $list = $model->attributes();
        $html .= '{'.implode('}, {', $list).'}';
        return $html;
    }

    /**
     * Возвращает список (через запятую) доступных в модели событий
     * @return string
     */
    public function actionEvents()
    {
        $by= $_GET['by'];
        $className = 'app\models\\'.$by;
        $model = new $className();
        $list = $model->getEvents();
        return implode(',', $list);
    }

    /**
     * Updates an existing Triggers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $_POST = Yii::$app->request->post();
        if (isset($_POST['Triggers'])){
            $model->attributes=$_POST['Triggers'];
            if(isset($model->type) && is_array($model->type))
                $model->type=implode(',',$model->type);
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }
        if(isset($model->type) && $model->type!=='')
            $model->type=explode(',',$model->type);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Triggers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Triggers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Triggers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Triggers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
