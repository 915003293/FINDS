<?php
    if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
    define('APP_DEBUG',True);
    if(file_exists("Application/Install/install.lock")){
        $_GET['m'] = 'Admin';
        $_GET['c'] = 'Login';
        $_GET['a'] = 'Login';
    }else{
        die('current not install,please run install.php file');
    }
    define('APP_PATH','./Application/');
    define('PLUGIN_PACH',APP_PATH.'Plugin/');
    define('FILE_PACH',APP_PATH.'File/');
    define('ADDON_PATH',APP_PATH.'Plugin/');
    require './ThinkPHP/ThinkPHP.php';
