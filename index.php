<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'app/config/config.php';

$viewFile = require_once 'router/web.php';

require_once 'views/layout/header.php';

require_once $viewFile;

require_once 'views/layout/footer.php';
