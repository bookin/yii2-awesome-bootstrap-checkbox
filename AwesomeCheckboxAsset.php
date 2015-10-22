<?php
namespace bookin\awesome\checkbox;

use yii\web\AssetBundle;

class AwesomeCheckboxAsset extends AssetBundle
{
    public $sourcePath = '@bower/awesome-bootstrap-checkbox';

    public $js = [
        'awesome-bootstrap-checkbox.css',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}