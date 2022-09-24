<?php

namespace helpers\editor;

use yii\web\AssetBundle;

class ConfigAsset extends AssetBundle
{
    public $sourcePath = '@vendor/portaflex/helpers/editor/js/';
    public $js = [
        'config.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}
