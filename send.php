#!/usr/bin/env php
<?php

include 'Zend/Loader/Autoloader.php';

set_include_path(implode(PATH_SEPARATOR, array(realpath(__DIR__.'/library'), get_include_path())));

$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('Fdrop');
$fdropit = new Fdrop_Service_Send();
$receipt = $fdropit->fdrop($argv[0]);

echo "{$receipt['drop']}\n";
