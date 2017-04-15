<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main frontend application asset bundle.
 */
class WebshopAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/webshop.css',

    ];
    public $js = [
       'js/jquery-1.8.2.min.js',
       'js/my.js',
    ];
    public $depends = [
        'yii\web\YiiAsset', // yii.js, jquery.js
        'yii\bootstrap\BootstrapAsset', // bootstrap.css
        'yii\bootstrap\BootstrapPluginAsset' // bootstrap.js
    ];


}
