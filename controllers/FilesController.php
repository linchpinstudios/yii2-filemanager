<?php

namespace linchpinstudios\filemanager\controllers;

use Yii;
use linchpinstudios\filemanager\models\Files;
use linchpinstudios\filemanager\models\FilesSearch;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Aws\S3\S3Client;
use yii\imagine\Image;
use linchpinstudios\filemanager\assets\FilemanagerAssets;

/**
 * FilesController implements the CRUD actions for Files model.
 */
class FilesController extends Controller
{

    public $page_size = 12;

    private $typeMap = [
        'application/pdf'   => '.pdf',
        'application/zip'   => '.zip',
        'image/gif'         => '.gif',
        'image/jpeg'        => '.jpg',
        'image/png'         => '.png',
        'text/css'          => '.css',
        'text/html'         => '.html',
        'text/javascript'   => '.js',
        'text/plain'        => '.txt',
        'text/xml'          => '.xml',
    ];
    
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

        FilemanagerAssets::register($this->view);
        
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
     * Lists all Files models.
     * @return mixed
     */
    public function actionTinymce()
    {
    
        $this->layout = 'tinymce';

        FilemanagerAssets::register($this->view);
        
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
    
    
    public function actionGetimage($id){
        
        Yii::$app->response->getHeaders()->set('Vary', 'Accept');
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $model = $this->findModel($id);
        
        $awsConfig = $this->module->aws;
        
        if($awsConfig['enable']){
            $model->url = $awsConfig['url'].$model->url;
        }else{
            $model->url = $model->url;
        }
        
        return $model;
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
        
        $name = time().'-'.md5($file->name).$this->typeMap[$file->type];
        
        //Upload file
            if($awsConfig['enable']){
                
                $this->uploadAws($file,$name);
                
                $url = $awsConfig['url'];
                
            }else{
                
                $file->saveAs($path.$name);
                
                $url = '';
                
            }
        
        //Create Thumbnails
            if(!empty($thumbnails)){
                $this->createThumbnails($file,$name); 
            }
        
        
        $model->user_id = 0;
        $model->url = $path.$name;
        $model->thumbnail_url = $path.'thumbnails/'.$name;
        $model->file_name = $name;
        $model->title = $file->name;
        $model->type = $file->type;
        $model->title = $file->name;
        $model->size = $file->size;
        /*$model->width = $size[0];
        $model->height = $size[1];*/
        
        $model->save();
        
        $response['files'][] = [
            'url' => $url.$model->url,
            'thumbnailUrl' => $url.$model->thumbnail_url,
            'name' => $model->title,
            'type' => $model->type,
            'size' => $model->size,
            'deleteUrl' => \Yii::$app->urlManager->createUrl(['filemanager/files/delete']),
            'deleteType' => 'POST',
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
        Yii::$app->response->getHeaders()->set('Vary', 'Accept');
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $model = $this->findModel($id);
        
        $awsConfig = $this->module->aws;
        
        $files = [
            ['Key' => $model->url],
            /*['Key' => $model->thumbnail_url],*/
        ];
                
        if($awsConfig['enable']){
        
            $this->deleteAws($files);
            
        }else{
            
            foreach($files as $f){
                
                unlink($f);
                
            }
            
        }
        
        $model->delete();
        
        $result = [
            'success' => 'true',
        ];
        
        return $result;
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
    
    
    
    protected function createThumbnails($file,$name = null)
    {
        
        if(is_null($name)){
            $name = $file->name;
        }
        
        $awsConfig = $this->module->aws;
        
        $thumbnails = $this->module->thumbnails;
        
        $path = $this->module->path;
        
        if($awsConfig['enable']){
            $path = $awsConfig['url'].$path;
        }
        
        foreach($thumbnails as $tn){
            
            $thumb = Image::thumbnail($path.$name, $tn[0], $tn[1], \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET);
            
            //Upload file
            if($awsConfig['enable']){
                
                if (!file_exists('temp')) {
                    mkdir('temp', 0777, true);
                }
                
                $thumb->save('temp/'.$name);
                
                $fc = new \stdClass();
                $fc->tempName = 'temp/'.$name;
                $fc->type = mime_content_type($file->tempName);
                
                $this->uploadAws($fc,$name,true);
                
                unlink($fc->tempName);
                
            }else{
                
                if (!file_exists($path.'thumbnails')) {
                    mkdir($path.'thumbnails', 0777, true);
                }
                
                $thumb->save($path.'thumbnails/'.$name);
                
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
        
        $config = [
            'key'    => $awsConfig['key'],
            'secret' => $awsConfig['secret'],
        ];
        $aws = S3Client::factory($config);
        
        return $aws;
    }
    
    
    
    
    protected function uploadAws($file,$name = null,$thumb = false,$path = null){
        
        if(is_null($path)){
            $path = $this->module->path;
        }
        
        if(is_null($name)){
            $name = $file->name;
        }
        
        if($thumb){
            $path = $path.'thumbnails/';
        }
        
        $awsConfig = $this->module->aws;
        
        $aws = $this->awsInit();
        
        $aws->get('S3');
        
        $aws->putObject([
            'Key' => $path.$name,
            'Bucket' => $awsConfig['bucket'],
            'SourceFile' => $file->tempName,
            'ContentType' => $file->type,
        ]);
        
    }
    
    
    
    
    protected function deleteAws($files){
        
        $awsConfig = $this->module->aws;
        
        $aws = $this->awsInit();
        
        $aws->get('S3');
        
        $aws->deleteObjects([
            'Bucket' => $awsConfig['bucket'],
            'key' => $files[0],
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
