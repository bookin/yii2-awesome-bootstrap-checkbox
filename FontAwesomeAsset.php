<?php

namespace bookin\awesome\checkbox;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@bower/font-awesome';

    public $js = [
        'css/font-awesome.min.css',
    ];
}