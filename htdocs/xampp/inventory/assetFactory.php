<?php

use Assetic\Factory\AssetFactory;
use Assetic\Factory\Worker\CacheBustingWorker;


$factory = new AssetFactory('_asset');
$factory->setAssetManager($am);
$factory->setFilterManager($fm);
$factory->setDebug(true);
$factory->addWorker(new CacheBustingWorker());

$css = $factory->createAsset(array(
    '@reset',         // load the asset manager's "reset" asset
    '/../_css/*.css',
), array(
    'css',           // filter through the filter manager's "css" filter
    '?yui_css',       // don't use this filter in debug mode
));

echo $css->dump();