<?php

namespace linchpinstudios\filemanager\controllers;

use Yii;
use linchpinstudios\filemanager\models\Files;
use linchpinstudios\filemanager\models\FilesSearch;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\HttpException;
use yii\web\Response;
use Aws\S3\S3Client;

/**
 * FilesController implements the CRUD actions for Files model.
 */
class FilesController extends Controller
{
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Files models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Files();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    
    /**
     * actionFilemodal function.
     * 
     * @access public
     * @return void
     */
    public function actionFilemodal(){
        $this->layout = 'modal';
        
        $model = new Files;
        
        return $this->render('fileModal',['model' => $model]);
    }
    
    
    public function actionUpload()
    {
        Yii::$app->response->getHeaders()->set('Vary', 'Accept');
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $model = new Files();
        
        $path = $this->module->path;
        $awsConfig = $this->module->aws;
        $thumnails = $this->module->thumnails;
        
        $file = UploadedFile::getInstance($model,'file_name');
        
        if($asw['enabled']){
            
            $aws = $this->awsInit();
            
            $aws->get('S3');
            $aws->putObject([
                'key' => $path.$file->name,
                'Bucket' => $awsConfig['bucket'],
            ]);
            
        }else{
            
            $file->saveAs($path.$file->name);
        }
        
        $model->user_id = 0;
        $model->url = $path.$file->name;
        $model->thumbnail_url = $path.$file->name;
        $model->file_name = $file->name;
        $model->title = $file->name;
        $model->type = $file->type;
        $model->title = $file->name;
        $model->size = $file->size;
        $model->width = $size[0];
        $model->height = $size[1];
        
        $model->save();
        
        $response['files'][] = [
            'url' => $model->url,
            'thumbnail_url' => $model->url,
            'name' => $model->file_name,
            'type' => $model->type,
            'size' => $model->size,
            'delete_url' => 'files/delete',
            'delete_type' => 'DELETE',
        ];
        
        return $response;
        
    }

    /**
     * Displays a single Files model.
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
     * Creates a new Files model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Files();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Files model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Files model.
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
     * Finds the Files model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Files the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Files::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    protected function awsInit(){
        
        $awsConfig = $this->module->aws;
        
        if($awsConfig['key'] == ''){
            throw new InvalidConfigException('Key cannot be empty!');
        }
        if($awsConfig['secret'] == ''){
            throw new InvalidConfigException('Secret cannot be empty!');
        }
        if($awsConfig['bucket'] == ''){
            throw new InvalidConfigException('Bucket cannot be empty!');
        }
        
        $config = array(
            'key'    => $aws['key'],
            'secret' => $aws['secret'],
        );
        $aws = S3Client::factory($config);
        
        return $aws;
    }
}
