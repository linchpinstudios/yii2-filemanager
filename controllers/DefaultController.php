<?php

namespace linchpinstudios\filemanager\controllers;

use yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $view = $this->getView();
/*
        DateTimePickerAssets::register($view);

        $id = $this->options['id'];

        $options = Json::encode($this->clientOptions);
*/
        $view->registerJs("\$(function(){\$('#filemanager-upload').modal();});");
    
        return $this->render('index');
    }
    
    
    public function actionUpload()
    {
           
        $tour = Tour::findOne($id);
        if (!$tour) {
            throw new NotFoundHttpException(Yii::t('app', 'Page not found'));
        }
        $picture = new TourPicture(['scenario' => 'upload']);
        $picture->tour_id = $id;
        $picture->image = UploadedFile::getInstance($picture, 'image');
        if ($picture->image !== null && $picture->validate(['image'])) {

            Yii::$app->response->getHeaders()->set('Vary', 'Accept');
            Yii::$app->response->format = Response::FORMAT_JSON;

            $response = [];

            if ($picture->save(false)) {
                $response['files'][] = [
                    'name' => $picture->image->name,
                    'type' => $picture->image->type,
                    'size' => $picture->image->size,
                    'url' => $picture->getImageUrl(),
                    'thumbnailUrl' => $picture->getImageUrl(TourPicture::SMALL_IMAGE),
                    'deleteUrl' => Url::to(['delete', 'id' => $picture->id]),
                    'deleteType' => 'POST'
                ];
            } else {
                $response[] = ['error' => Yii::t('app', 'Unable to save picture')];
            }
            @unlink($picture->image->tempName);
        } else {
            if ($picture->hasErrors(['picture'])) {
                $response[] = ['error' => HtmlHelper::errors($picture)];
            } else {
                throw new HttpException(500, Yii::t('app', 'Could not upload file.'));
            }
        }
        return $response;
    }
    
    
    
}
