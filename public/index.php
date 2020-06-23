<?php
declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2017/12/27
 * Time: 11:25
 */

define('ROOT_PATH',  dirname(__DIR__));
define('VIEW_PATH', ROOT_PATH. '/app/Views');
define('CACHE_PATH', ROOT_PATH.'/cache');
define('PUBLIC_PATH', ROOT_PATH.'/public');
require_once ROOT_PATH.'/lib/AutoLoad.php';
Core::Run();
