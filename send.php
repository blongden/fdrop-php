<?php

include 'Zend/Loader/Autoloader.php';

set_include_path(implode(PATH_SEPARATOR, array(realpath('./library'), get_include_path())));

$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('Fdrop');
$fdropit = new Fdrop_Service_Send();
$receipt = $fdropit->fdrop('/mnt/hgfs/ben On My Mac/Pictures/London-apocalypse-1920-1200.jpg');

echo "{$receipt['drop']}\n";
