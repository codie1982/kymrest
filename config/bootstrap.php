<?php

// https://www.youtube.com/playlist?list=PLFPkAJFH7I0keB1qpWk5qVVUYdNLTEUs3

require_once (ROOT . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'config' . DS . 'iyzico_start.php');
require_once (ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'function.php');


//$siteSettings = new table_settings_general();
//
define("MAINTENANCE", 0);


define("SLIDERTHUMBNAIL", FALSE);
ini_set('max_execution_time', 300);
ini_set("allow_url_fopen", 1);
