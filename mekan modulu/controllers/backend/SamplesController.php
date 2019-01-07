<?php

namespace kouosl\muayene\controllers\backend;

use kouosl\muayene\models\muayeneData;
use kouosl\muayene\models\UploadImage;
use Yii;
use kouosl\muayene\models\muayenes;
use kouosl\muayene\models\muayenesSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use yii\web\Session;
use yii\web\UploadedFile;

/**
 * muayenesController implements the CRUD actions for muayene model.
 */
class muayenesController extends DefaultController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
                ],
            ],
        ];
    }
    public function init(){
    	parent::init();
    
    }

    public function actionIndex()
    {
        return $this->actionManage();
    }

    /**
     * Lists all muayene models.
     * @return mixed
     */
    public function actionManage()
    {
    	

    	
        $searchModel = new muayenesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_manage', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single muayene model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

    	
        return $this->render('_view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new muayene model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

    	
        $model = new muayenes();

        $uploadImage = new UploadImage();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $uploadImage->imageFile =  UploadedFile::getInstance($uploadImage, 'imageFile');

            $model->picture = $uploadImage->upload();

            if(!$model->save()){

                yii::$app->session->setFlash('flashMessage', ['type' => 'error', 'message' => Module::t('muayene', 'muayene Not Saved' )]);

                return $this->render('_create', ['model' => $model]); // error
            }

            return $this->redirect(['view', 'id' => $model->id]);

        } else {

            return $this->render('_create', [
                'model' => $model,
                'uploadImage' => $uploadImage
            ]);
        }
    }

    /**
     * Updates an existing muayene model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	

    	
        $model = $this->findModel($id);


        $uploadImage = new UploadImage();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $uploadImage->imageFile =  UploadedFile::getInstance($uploadImage, 'imageFile');

            if($imageName = $uploadImage->upload())
                $model->picture = $imageName;

            if(!$model->save()){

                yii::$app->session->setFlash('flashMessage', ['type' => 'error', 'message' => Module::t('muayene', 'muayene Not Saved' )]);

                return $this->render('_update', ['model' => $model]); // error
            }

            return $this->redirect(['view', 'id' => $model->id]);

        } else {

            return $this->render('_update', [
                'model' => $model,
                'uploadImage' => $uploadImage
            ]);
        }
    }

    /**
     * Deletes an existing muayene model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        muayeneData::deleteAll(['muayene_id' => $id]);

        $model = $this->findModel($id);

        unlink($model->imagePath);

        $model->delete();

        yii::$app->session->setFlash('flashMessage', ['type' => 'success', 'message' => 'Attemp Başarılı Bir Şekilde Silindi!']);

        return $this->redirect(['manage']);

    }

    /**
     * Finds the muayene model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return muayene the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = muayenes::findOne($id)) !== null) {

            return $model;

        } else {

            throw new NotFoundHttpException('The requested page does not exist.');

        }
    }
}
