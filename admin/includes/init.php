<?php

defined('DS') ? NULL : define('DS',DIRECTORY_SEPARATOR);
define('SITE_ROOT',DS.'var'.DS.'www'.DS.'html'.DS.'gallary');
defined('INCLUDES_PATH') ? NULL : define('INCLUDES_PATH',SITE_ROOT.DS.'admin'.DS.'includes');

include("functions.php");
include("new_config.php");
include("database.php");
include("db_object.php");
include("user.php");
include("photo.php");
include("session.php");


 ?>
