<?php


namespace app\modules\backend\controllers;


use yii\web\Controller;

class BaseController extends Controller
{
    public $layout = false;
    public $enableCsrfValidation = false;
    
}