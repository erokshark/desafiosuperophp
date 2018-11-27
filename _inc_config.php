<?php

sleep(10);
 
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
//error_reporting(E_ALL);
ini_set('display_errors', 1);

@header('Content-type: text/html; charset=utf-8');
ini_set('default_charset', 'UTF-8');
date_default_timezone_set("America/Sao_Paulo");

set_time_limit(120);
ini_set("memory_limit","250M");

if(! isset($_SESSION)) {
    @session_start();
}

if( ! @defined(DB_HOST) )
{
    define('DB_HOST','localhost');
    define('DB_BASE','supero');
    define('DB_USER','root');
    define('DB_PASS','');

    define('ROOT',$_SERVER['DOCUMENT_ROOT']);       
    define('HOST','http://'.$_SERVER['HTTP_HOST']); // Rede      :  localhost
    define('PATH','/supero');
    define('DEBUG',isset($_REQUEST['debug']));
}

include(ROOT.PATH.'/classes/Conexao.php');
include(ROOT.PATH.'/classes/Task.php');

if(DEBUG)
{
    echo '<pre>';
    echo '    <br>ROOT = '.ROOT ;
    echo '    <br>HOST = '.HOST ;
    echo '    <br>PATH = '.PATH ;
    print_r($_SESSION);
    echo '    <br>$_SERVER = '.$srv_host ;
    print_r($_SERVER);
    echo '</pre>';
    exit();
}
