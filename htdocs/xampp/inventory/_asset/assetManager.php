<?php

use Assetic\Asset\AssetCollection;
use Assetic\AssetManager;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;

$am = new AssetManager();
$am->set('base_js', new AssetCollection(array(new GlobAsset('../_js/*'),
    new FileAsset('../vendor/components/jquery/jquery.min.js'),
    new FileAsset('../vendor/twbs/bootstrap/dist/js/bootstrap.min.js'),
)));
$am->set('bootstrap_css', new FileAsset('../vendor/twbs/bootstrap/dist/css/bootstrap.min.css'));
$am->set('base_css', new GlobAsset('../_css/*'));