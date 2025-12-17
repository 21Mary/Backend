<?php
$path= $_SERVER['REQUEST_URI'];
if(str_contains($path, 'types')){
    require_once('./types.php');
} else if(str_contains($path, 'purpose')){
    require_once('./purpose.php');
} else if(str_contains($path, 'properties')){
    require_once('./properties.php');
} else if(str_contains($path, 'salts')){
    require_once('./salts.php');
} else if(str_contains($path, 'profile')){
    require_once('./profile.php');
} else{
    echo "Invalid route";
}
?>