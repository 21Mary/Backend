<?php
session_start();
if (isset($_SESSION['user'])){
    header('HTTP/1.0 401 Unauthorized');
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
require_once('../app/SaltList.php');
$a=new SaltList();
$a->readFromCSV('../data/salts.csv');
if($_SERVER['REQUEST_METHOD']=='POST'){
    $json_data = file_get_contents('php://input');
    $data=json_decode($json_data,true);
    $a->add(['name'=>$data['name'],
            'formula'=>$data['formula'],
            'type'=>$data['type'],
            'purpose'=>$data['purpose'],
            'marking'=>$data['marking'],
            'properties'=>$data['properties']
]);
    $a->writeToCSV('../data/salts.csv');
    echo "OK!";
}
if($_SERVER['REQUEST_METHOD']=='UPDATE'){
    $json_data = file_get_contents('php://input');
    $data=json_decode($json_data,true);
    $a->update(['id'=>$data['id'],'name'=>$data['name'],
            'formula'=>$data['formula'],
            'type'=>$data['type'],
            'purpose'=>$data['purpose'],
            'marking'=>$data['marking'],
            'properties'=>$data['properties']]);
    $a->writeToCSV('../data/salts.csv');
    echo "OK!";
}
else if($_SERVER['REQUEST_METHOD']=='DELETE'){
    $a->delete($_REQUEST['id']);
    $a->writeToCSV('../data/salts.csv');
} 
else if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['id'])){
        echo json_encode($a->getById($_GET['id']));
    } else{
        echo $a->getAsJSON();
    }
    
}