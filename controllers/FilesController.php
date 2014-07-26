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
use yii\imagine\Image;

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
                    'upload' => ['post'],
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
    
    
    /**
     * actionUpload function.
     * 
     * @access public
     * @return string JSON
     */
    public function actionUpload()
    {
        Yii::$app->response->getHeaders()->set('Vary', 'Accept');
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $model = new Files();
        
        $path = $this->module->path;
        $awsConfig = $this->module->aws;
        $thumbnails = $this->module->thumbnails;
        
        $file = UploadedFile::getInstance($model,'file_name');
        
        
        //Upload file
            if($awsConfig['enable']){
                
                $this->uploadAws($file);
                
            }else{
                
                $file->saveAs($path.$file->name);
                
            }
        
        //Create Thumbnails
            if(!empty($thumbnails)){
                $this->createThumbnails($file);
                
            }
        
        
        $model->user_id = 0;
        $model->url = $path.$file->name;
        $model->thumbnail_url = $path.$file->name;
        $model->file_name = $file->name;
        $model->title = $file->name;
        $model->type = $file->type;
        $model->title = $file->name;
        $model->size = $file->size;
        /*$model->width = $size[0];
        $model->height = $size[1];*/
        
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
    
    
    
    protected function createThumbnails($file)
    {
        
        $awsConfig = $this->module->aws;
        
        $thumbnails = $this->module->thumbnails;
        
        $path = $this->module->path;
        
        error_log(print_r($file,true));
        
        foreach($thumbnails as $tn){
            
            $thumb = Image::thumbnail($path.$file->name, $tn[0], $tn[1]);
            
            //Upload file
            if($awsConfig['enable']){
                
                $this->uploadAws($file,true);
                
            }else{
                
                $thumb->saveAs($path.'thumbnails/'.$file->name);
                
            }
            
        }
        
        return true;
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
            'key'    => $awsConfig['key'],
            'secret' => $awsConfig['secret'],
        );
        $aws = S3Client::factory($config);
        
        return $aws;
    }
    
    
    
    
    protected function uploadAws($file,$thumb = false,$path = null){
        
        if(is_null($path)){
            $path = $this->module->path;
        }
        
        if($thumb){
            $path = $path.'thumbnails/';
        }
        
        error_log($path);
        
        $awsConfig = $this->module->aws;
        
        $aws = $this->awsInit();
        
        $aws->get('S3');
        
        $aws->putObject([
            'Key' => $path.$file->name,
            'Bucket' => $awsConfig['bucket'],
            'SourceFile' => $file->tempName,
        ]);
        
    }
    
    
    
    
    protected function convertPHPSizeToBytes($sSize)  
    {  
        if ( is_numeric( $sSize) ) {
           return $sSize;
        }
        $sSuffix = substr($sSize, -1);  
        $iValue = substr($sSize, 0, -1);  
        switch(strtoupper($sSuffix)){  
        case 'P':  
            $iValue *= 1024;  
        case 'T':  
            $iValue *= 1024;  
        case 'G':  
            $iValue *= 1024;  
        case 'M':  
            $iValue *= 1024;  
        case 'K':  
            $iValue *= 1024;  
            break;  
        }  
        return $iValue;  
    }  

    protected function getMaximumFileUploadSize()  
    {  
        return min(convertPHPSizeToBytes(ini_get('post_max_size')), convertPHPSizeToBytes(ini_get('upload_max_filesize')));  
    }  
    
    
}
