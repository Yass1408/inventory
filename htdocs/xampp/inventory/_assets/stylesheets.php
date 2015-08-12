<?php


use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;
use Assetic\Filter\CssMinFilter;

$css = new AssetCollection(array(
    new GlobAsset('../_css/*'),
    new FileAsset('../vendor/twbs/bootstrap/dist/css/bootstrap.min.css'),
), array(
    new CssMinFilter(),
));

// this will echo CSS minified
echo $css->dump();