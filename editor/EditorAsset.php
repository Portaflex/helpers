<?php

namespace helpers\editor;

use yii\web\AssetBundle;

class EditorAsset extends AssetBundle
{
    public $sourcePath = '@vendor/ckeditor/ckeditor/';
    public $js = [
        'ckeditor.js',
        'adapters/jquery.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}
