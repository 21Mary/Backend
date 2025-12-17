<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once('../app/Profile.php');
$profile=new Profile();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $json_data = file_get_contents('php://input');
    $data=json_decode($json_data,true);
    $loginError=null;
        if($profile->checkLogin(['login'=>$data['login'],'password'=>$data['password']])){
            $_SESSION['user']='user';
            echo '{"login":true}';
        } else{
            echo '{"login":false}';
        }
}

else if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset ($_GET['action'])&&$_GET['action']=='logout'){
        session_destroy();
        echo '{"login":false}';
    } else{
        if(!isset($_SESSION['user'])){
            echo '{"login":false}';
        } else{
            echo '{"login":true}';
        }
    }
}