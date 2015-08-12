<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;
use Assetic\Filter\JSMinFilter;

$js = new AssetCollection(array(
    new GlobAsset('../_js/*'),
    new FileAsset('../vendor/components/jquery/jquery.min.js'),
    new FileAsset('../vendor/twbs/bootstrap/dist/js/bootstrap.min.js')
), array(
    new JSMinFilter()
));

// the code is merged when the asset is dumped
echo $js->dump();

