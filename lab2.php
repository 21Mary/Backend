<?php
//Task 3.1
function task31(){
    $z=null;
    $x=1;
    $y=4;
    if(abs($x * $y) < 1 && $x < 0){
        $z=($x + $y) / exp($x * $y);
    } else if($x > 2 && $y <= 0){
        $z=-pow(log($x), 2);
    } else if($y > 0 && $x >= 0 && $x <= 2){
        $z=log10(sqrt($y));
    } else{
        $z="No result";
    }
    echo "Result of task 3.1: ".$z."</br>";
}
//Task 4.1
function task41(){
    echo "Result of task 4.1:</br> ";
    for($t=0;$t<=6.5;$t+=1.1){
        $z=(2.3 * $t + 8) / (abs(2*cos($t))+1);
        echo $z."</br>";
    }
    echo "Result of task 4.2:</br> ";
    $t=0.4;
    $n=7;
    while($n>0){
        $z=(2.3 * $t + 8) / (abs(2*cos($t))+1);
        echo $z."</br>";
        $t+=0.9;
        $n--;
    }
}
//Task 5.1
function task51(){
    $sum=0;
    $i=4;
    $k=11;
    for($n=$i;$n<=$k;$n++){
        $sum+= $n / (pow($n,2) + 5 * $n + 6);
    }
    echo "Result of task 5.1: ".$sum."</br>";
    $product=1;
    for($l=11;$l<=17;$l++){
        $product*= pow (-1, $l) * ((3 * $l - 4) / (pow ($l,2) + 7));
    }
    echo "Result of task 5.2: ".$product."</br>";
}
//Task 7.2
function task72(){
    $x=[-2.3,4.0,-8.9,6.3,4.9,-7.8,-6.5,5.1,3.8,-4.3,-5.1,7.2];
    $sum = 0;
    for($i=1;$i<count($x);$i+=2){
        if(($x[$i]) < 0 ){
            $sum += $x[$i];
        }
    }
    echo "Result of task 7.2: ".$sum."</br>";
}
task31();
task41();
task51();
task72();
?>