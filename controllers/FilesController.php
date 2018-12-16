<?php

namespace linchpinstudios\filemanager\controllers;

use Yii;
use linchpinstudios\filemanager\models\Files;
use linchpinstudios\filemanager\models\FilesSearch;
use linchpinstudios\filemanager\models\FileTag;
use linchpinstudios\filemanager\models\FileTagRelationships;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\view;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use Aws\S3\S3Client;
use yii\imagine\Image;
use linchpinstudios\filemanager\assets\FilemanagerAssets;

/**
 * FilesController implements the CRUD actions for Files model.
 */
class FilesController extends Controller
{

    protected $accept;

    public $page_size = 12;

    private $typeMap = [
        'application/pdf'                      => '.pdf',
        'application/zip'                      => '.zip',
        'image/gif'                            => '.gif',
        'image/jpeg'                           => '.jpg',
        'image/png'                            => '.png',
        'text/css'                             => '.css',
        'text/html'                            => '.html',
        'text/javascript'                      => '.js',
        'text/plain'                           => '.txt',
        'text/xml'                             => '.xml',
        'application/octet-stream'             => '.kml',
        'application/vnd.google-earth.kmz'     => '.kmz',
    ];

    private $extentionMap = [
        '.kml'  => 'application/octet-stream',
        '.kmz'  => 'application/vnd.google-earth.kmz',
        'pdf'   => 'application/pdf',
        'zip'   => 'application/zip',
        'gif'   => 'image/gif',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'png'   => 'image/png',
        'css'   => 'text/css',
        'html'  => 'text/html',
        'js'    => 'text/javascript',
        'txt'   => 'text/plain',
        'xml'   => 'text/xml',
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



    public function __construct($id, $module, $config = [])
    {
        $this->accept = Yii::$app->request->getHeaders()->get('Accept');
        parent::__construct($id, $module, $config);
    }



    /**
     * beforeAction function.
     *
     * @access public
     * @param mixed $action
     * @return void
     */
    public function beforeAction($action) {

        $result = parent::beforeAction($action);

        $options = [
           'tinymce'             => \Yii::$app->urlManager->createUrl('/filemanager/files/tinymce'),
           'properties'          => \Yii::$app->urlManager->createUrl('/filemanager/files/properties'),
        ];
        $this->getView()->registerJs("filemanager.init(".json_encode($options).");", \yii\web\View::POS_END, 'my-options');

        return $result;
    }




    /**
     * Lists all Files models.
     * @return mixed
     */
    public function actionIndex()
    {

        FilemanagerAssets::register($this->view);

        $searchModel  = new FilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model        = new Files();

        if ($this->accept == 'application/json') {
            $models = $dataProvider->getModels();

            foreach ($models as $model) {
                $model->thumbnail_url = \Yii::$app->getModule('filemanager')->url . $model->thumbnail_url;
                $model->url = \Yii::$app->getModule('filemanager')->url . $model->url;
            }
            $pagination = $dataProvider->pagination;
            $data = [
                'links' => $pagination->links,
                'page' => $pagination->page++,
                'pageCount' => $pagination->pageCount,
                'images' => $dataProvider->getModels(),
            ];
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $data;
        }

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
     * [actionGetimage description]
     * @param [type] $id [description]
     */
    public function actionGetimage($id){

        Yii::$app->response->getHeaders()->set('Vary', 'Accept');
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = $this->findModel($id);

        $awsConfig = $this->module->aws;

        if($awsConfig['enable']){
            $model->url = $this->module->url.$model->url;
        }else{
            $model->url = '/'.$model->url;
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

        $path       = $this->module->path;
        $thumbPath  = $this->module->thumbPath;
        $directory  = Yii::getAlias( $this->module->directory );
        $url        = $this->module->url;
        $awsConfig  = $this->module->aws;
        $thumbnails = $this->module->thumbnails;

        $file = UploadedFile::getInstance($model,'file_name');

        $name = time().'-'.md5($file->name).$this->typeMap[$file->type];

        //Upload file
            if($awsConfig['enable']){
                $this->uploadAws($file,$name);
            }else{
                if ( !file_exists( $directory . $path ) ) {
                    //FileHelper::createDirectory( $directory . $path, 775);
                    mkdir($directory . $path, 0755, true);
                }

                $file->saveAs( $directory . $path . $name);
            }

        //Create Thumbnails
            if(!empty($thumbnails) && ($file->type == 'image/gif' || $file->type == 'image/jpeg' || $file->type == 'image/png')){
                $this->createThumbnails($file,$name);
            }


        $model->user_id         = 0;
        $model->url             = $path.$name;
        $model->thumbnail_url   = $thumbPath.$name;
        $model->file_name       = $name;
        $model->title           = $file->name;
        $model->type            = $file->type;
        $model->title           = $file->name;
        $model->size            = $file->size;
        /*$model->width         = $size[0];
        $model->height          = $size[1];*/

        if($model->save()){

            $response['files'][] = [
                'id'            => $model->id,
                'url'           => $url.$model->url,
                'thumbnailUrl'  => $url.$model->thumbnail_url,
                'name'          => $model->title,
                'type'          => $model->type,
                'size'          => $model->size,
                'deleteUrl'     => \Yii::$app->urlManager->createUrl(['filemanager/files/delete']),
                'deleteType'    => 'POST',
            ];

            return $response;

        }else{

            error_log(print_r($model->getErrors(),true));

            return false;
        }

    }




    /**
     * Displays a single Files model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($this->accept == 'application/json') {

            $model->thumbnail_url = \Yii::$app->getModule('filemanager')->url . $model->thumbnail_url;
            $model->url = \Yii::$app->getModule('filemanager')->url . $model->url;

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $model;
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Files model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        FilemanagerAssets::register($this->view);

        $model = new Files();
        $tags = FileTag::find()->orderBy('name')->all();
        $newTag = new FileTag;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            FileTagRelationships::deleteAll('file_id = '.$model->id);
            $fielTags = new FileTagRelationships;
            $data = Yii::$app->request->post();

            if ( isset($data['tags']) ) {
                foreach ($data['tags'] as $value) {
                    $fielTags->isNewRecord    = true;
                    $fielTags->id             = null;
                    $fielTags->file_id = $model->id;
                    $fielTags->tag_id         = $value;
                    $fielTags->save();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'tags' => $tags,
                'newTag' => $newTag,
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

        FilemanagerAssets::register($this->view);

        $model = $this->findModel($id);
        $tags = FileTag::find()->orderBy('name')->all();
        $newTag = new FileTag;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            FileTagRelationships::deleteAll('file_id = '.$model->id);
            $fielTags = new FileTagRelationships;
            $data = Yii::$app->request->post();

            if ( isset($data['tags']) ) {
                foreach ($data['tags'] as $value) {
                    $fielTags->isNewRecord    = true;
                    $fielTags->id             = null;
                    $fielTags->file_id = $model->id;
                    $fielTags->tag_id         = $value;
                    $fielTags->save();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'tags' => $tags,
                'newTag' => $newTag,
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
            ['Key' => $model->thumbnail_url],
        ];

        if($awsConfig['enable']){

            $this->deleteAws($files);

        }else{

            foreach($files as $f){

                if( file_exists( Yii::getAlias( $this->module->directory ) . $f['Key'] ) ){
                    unlink( Yii::getAlias( $this->module->directory ) . $f['Key']);
                }

            }

        }

        $model->delete();

        $this->redirect(['index']);
    }





    public function actionProperties()
    {


        return $this->renderPartial('_properties');
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

        $directory  = Yii::getAlias( $this->module->directory );

        if($awsConfig['enable']){
            $path = $this->module->url.$path;
        }

        foreach($thumbnails as $tn){

            $thumb = Image::thumbnail($path.$name, $tn[0], $tn[1], \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET);

            //Upload file
            if($awsConfig['enable']){

                if (!file_exists('temp')) {
                    mkdir('temp', 0777, true);
                }

                $thumb->save('temp/'.$name);

                $fileInfo = pathinfo($file);

                $fc             = new \stdClass();
                $fc->tempName   = 'temp/'.$name;
                $fc->type       = $this->extentionMap[strtolower($fileInfo['extension'])];

                $this->uploadAws($fc,$name,true);

                unlink($fc->tempName);

            }else{

                if ( !file_exists( $directory . $this->module->thumbPath) ) {
                    mkdir($directory . $this->module->thumbPath, 0755, true);
                }

                $thumb->save( $directory . $this->module->thumbPath . $name );

            }

        }

        return true;
    }



    /**
     * [awsInit description]
     */
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
            $path = $this->module->thumbPath;
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
            'Objects' => $files,
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
