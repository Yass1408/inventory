<?php

use Assetic\FilterManager;
use Assetic\Filter\CssMinFilter;
use Assetic\Filter\JSMinFilter;


$fm = new FilterManager();
$fm->set('cssMin', new CssMinFilter());
