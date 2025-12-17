<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if(!$_SESSION['user']){
    header('Location: login.php');
}
require_once('../app/SaltList.php');
require_once('../app/TypeList.php');
require_once('../app/PurposeList.php');
require_once('../app/PropertyList.php');
$typList=new TypeList();
$typList->getAllFromDatabase();
$purList=new PurposeList();
$purList->getAllFromDatabase();
$propList=new PropertyList();
$propList->getAllFromDatabase();
$propArray=$propList->getAsAssocArray();
$a = new SaltList();
$item=null;
$itemProps=[];
if($_SERVER['REQUEST_METHOD']=='POST'){
    if($_POST['id']==""){
        $salt_id=$a->insertIntoDatabase(['name'=>$_POST['name'], 
        'formula'=>$_POST['formula'],
        'type_id'=>$_POST['typeid'],
        'purpose_id'=>$_POST['purposeid'], 
        'marking'=>$_POST['marking'],
]);
    for ($i=0;$i<count($propArray);$i++){
        if(isset($_POST['prop-'.$propArray[$i]['id']])){
            $a->addSaltProperty($salt_id,$propArray[$i]['id'],$_POST['prop-'.$propArray[$i]['id']]);
        }
    }
    } else{
        $propArray=$propList->getAsAssocArray();
        $a->updateDatabaseById(['id'=>$_POST['id'],
        'name'=>$_POST['name'], 
        'formula'=>$_POST['formula'],
        'type_id'=>$_POST['typeid'], 
        'purpose_id'=>$_POST['purposeid'], 
        'marking'=>$_POST['marking']]);
        for ($i=0;$i<count($propArray);$i++){
        if(isset($_POST['prop-'.$propArray[$i]['id']])){
            
            $a->updateSaltProperty($_POST['id'],$propArray[$i]['id'],$_POST['prop-'.$propArray[$i]['id']]);
        }
        }    
       
    }
 header('Location: salts.php');
} else{
    if(isset($_GET['search'])){
        $a->getAllFromDatabaseBySearchCriteria($_GET['search']);
    }else{
        $a->getAllFromDatabase();
    }
    if(isset($_GET['action'])&&$_GET['action']=='delete'){
        $a->deleteFromDatabaseById($_GET['id']);
        header('Location: salts.php');
    } else if(isset($_GET['action'])&&$_GET['action']=='update'){
        $item=$a->getById($_GET['id']);
        $itemProps=$a->getSaltPropertiesById($_GET['id']);
    }
    
}
?>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Солі</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
    </head>
    <body>
        <div class="container">
            <ul class="nav">
                <li><a class="btn btn-outline nav-btn" href="./types.php">Типи</a></li>
                <li><a class="btn btn-outline nav-btn" href="./purpose.php">Сфера призначення</a></li>
                <li><a class="btn btn-outline nav-btn" href="./properties.php">Характеристики</a></li>
                <li><a class="btn btn-outline nav-btn" href="./salts.php">Солі</a></li>
                <li><a class="btn btn-outline nav-btn" href="./logout.php">Вийти</a></li>
            </ul>
            <h1>Солі</h1>
            <div class="row">
                <div class="col-md-8">
                        <form method="GET">
                            <input type="text" required name="search" placeholder="Шукати"/>
                        <button type="submit" class="btn btn-primary">Пошук</button>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Назва</th>
                                <th>Позначення</th>
                                <th>Тип</th>
                                <th>Сфера призначення</th>
                                <th>Маркування</th>
                                <th>Характеристики</th>
                                <th>Дії</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $a->getAsTableBody();?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <form method="POST">
                        <p>
                            <input type="text" name="name" value="<?php echo $item?$item['name']:'';?>" class="form-control" placeholder="Назва" required/>
                        </p>
                        <p>
                            <input type="text" name="formula" value="<?php echo $item?$item['formula']:'';?>" class="form-control" placeholder="Позначення" required/>
                        </p>
                        <p>
                            <select name="typeid" class="form-select" placeholder="Тип" required><?php echo $typList->getAsSelectOptions($item?$item['type_id']:'');?></select>
                        </p>
                        <p>
                            <select name="purposeid" class="form-select" placeholder="Сфера призначення" required><?php echo $purList->getAsSelectOptions($item?$item['purpose_id']:'');?></select>
                        </p>                        
                        <p>
                            <input type="text" name="marking" value="<?php echo $item?$item['marking']:'';?>" class="form-control" placeholder="Маркування" required/>
                            
                        </p>
                        <?php echo $propList->getAsInputGroup($itemProps); ?>
                        <p>
                            <input type="hidden" name="id" value="<?php echo $item?$item['id']:'';?>"/>
                            <button class="btn btn-success" type="submit">Зберегти</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>