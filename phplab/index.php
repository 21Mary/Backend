<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('./app/SaltList.php');
require_once('./app/PurposeList.php');
require_once('./app/TypeList.php');
require_once('./app/PropertyList.php');
/*$a=new TypeList();
$a->readFromCSV('data/types.csv');
$a->add(['name'=>'Кислі солі']);
$a->display();
$a->writeToCSV('data/types.csv');*/
/*$a=new PurposeList();
$a->readFromCSV('data/purpose.csv');
$a->add(['name'=>'Лабораторні солі']);
$a->display();
$a->writeToCSV('data/purpose.csv');*/
/*$a=new PropertyList();
$a->readFromCSV('data/properties.csv');
$a->add(['name'=>'Ціна','units'=>'грн']);
$a->display();
$a->writeToCSV('data/properties.csv');*/
/*$a=new SaltList();
$a->readFromCSV('data/salts.csv');
$a->add(['name' => 'Сіль калійна',
    'formula' => 'KNO3',
    'type' => 'Мішана',
    'purpose' => 'Технічна',
    'marking' => 'CAS 7757-79-1',
    'properties' => '{"Розчинність":"Добра","Колір":"Безбарвна","Бренд":"Mineral",
"Країна":"Польща","Форма":"Порошок","Ціна":"80 грн","Маса":"0.5 кг"}'
]);
$a->display();
$a->writeToCSV('data/salts.csv');*/
