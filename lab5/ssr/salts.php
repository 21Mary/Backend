<?php
session_start();
if(!$_SESSION['user']){
    header('Location: login.php');
}
require_once('../app/SaltList.php');
$a = new SaltList();
$a->readFromCSV('../data/salts.csv');
function escapeJsonString($value) {
    # list from www.json.org: (\b backspace, \f formfeed)    
    $escapers =     array("\\",     "/",  "\n",  "\r",  "\t", "\x08", "\x0c","\'");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t",  "\\f",  "\\b","\\'");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
  }
$item=null;
if($_SERVER['REQUEST_METHOD']=='POST'){
    if($_POST['id']==""){
        $a->add(['name'=>$_POST['name'], 
        'formula'=>$_POST['formula'],
        'type'=>$_POST['type'], 
        'purpose'=>$_POST['purpose'],
        'marking'=>$_POST['marking'],
        'properties'=>$_POST['properties']
    ]);
        $a->writeToCSV('../data/salts.csv');
    } else{
        $a->update(['id'=>$_POST['id'],
        'name'=>$_POST['name'], 
        'formula'=>$_POST['formula'],
        'type'=>$_POST['type'], 
        'purpose'=>$_POST['purpose'],
        'marking'=>$_POST['marking'],
        'properties'=>$_POST['properties']]);
        $a->writeToCSV('../data/salts.csv');
        header('Location: salts.php');
    }
    
} else{
    if(isset($_GET['action'])&&$_GET['action']=='delete'){
        $a->delete($_GET['id']);
        $a->writeToCSV('../data/salts.csv');
        header('Location: salts.php');
    } else if(isset($_GET['action'])&&$_GET['action']=='update'){
        $item=$a->getById($_GET['id']);
    }
    
}
?>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Типи</title>
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
            <h1>Типи</h1>
            <div class="row">
                <div class="col-md-8">
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
                            <input type="text" name="type" value="<?php echo $item?$item['type']:'';?>" class="form-control" placeholder="Тип" required/>
                        </p>
                        <p>
                            <input type="text" name="purpose" value="<?php echo $item?$item['purpose']:'';?>" class="form-control" placeholder="Сфера призначення" required/>
                        </p>
                        <p>
                            <input type="text" name="marking" value="<?php echo $item?$item['marking']:'';?>" class="form-control" placeholder="Маркування" required/>
                        </p>
                        <p>
                            <input type="text" name="properties" value='<?php echo $item?escapeJsonString($item['properties']):'';?>' class="form-control" placeholder="Характеристики" required/>
                        </p>
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