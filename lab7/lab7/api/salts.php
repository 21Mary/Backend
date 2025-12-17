<?php
session_start();
if(!isset($_SESSION['user'])){
    header('HTTP/1.0 401 Unauthorized');
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
require_once('../app/SaltList.php');
require_once('../app/PropertyList.php');
$a=new SaltList();
$a->getAllFromDatabase();
$propList=new PropertyList();
$propList->getAllFromDatabase();
$propArray=$propList->getAsAssocArray();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $json_data = file_get_contents('php://input');
    $data=json_decode($json_data,true);
    $salt_id=$a->insertIntoDatabase(['name'=>$data['name'], 
        'formula'=>$data['formula'],
        'type'=>$data['type_id'], 
        'purpose'=>$data['purpose_id'],
        'marking'=>$data['marking'],
]);
    for ($i=0;$i<count($propArray);$i++){
            if(isset($data['prop_'.$propArray[$i]['id']])){
                $a->addSaltProperty($salt_id,$propArray[$i]['id'],$data['prop_'.$propArray[$i]['id']]);
            }
        }
    echo "OK!";
}
if($_SERVER['REQUEST_METHOD']=='UPDATE'){
    $json_data = file_get_contents('php://input');
    $data=json_decode($json_data,true);
    $a->updateDatabaseById(['id'=>$data['id'],
        'name'=>$data['name'], 
        'formula'=>$data['formula'],
        'type'=>$data['type_id'], 
        'purpose'=>$data['purpose_id'],
        'marking'=>$data['marking']]);
    for ($i=0;$i<count($propArray);$i++){
        if(isset($data['prop_'.$propArray[$i]['id']])){
            
            $a->updateSaltProperty($data['id'],$propArray[$i]['id'],$data['prop_'.$propArray[$i]['id']]);
        }
        }        
    echo "OK!";
}
else if($_SERVER['REQUEST_METHOD']=='DELETE'){
    $a->deleteFromDatabaseById($_GET['id']);
} 
else if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['id'])){
        $item=$a->getById($_GET['id']);
        $item['properties']=$a->getSaltPropertiesById($_GET['id']);
        echo json_encode($item);
    } else{
        echo $a->getAsJSON();
    }
    
}