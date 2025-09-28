<?php
	//task 1.1
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	$k=2;
	$x=1;
	$l=(1/exp(-$k * $x + 0.5)) * (((log10(abs($k+$x))-sqrt(pow(sin($x), 4))) / (abs(atan(($x+1)/($x-$k))+ (3.14/10)*log(3.14)) + 1)) + 2);
	echo 'Task 1.1 result: '.$l;
	echo '</br>';
	//task 1.2
	$x=1;
	$y=2;
	$z=3;
	$result= (($x-$y) <= ($z + (sqrt($x)))) && (($z + (sqrt($x))) <= (2*$y)); 
	echo 'Task 1.2 result: ';
	var_dump ($result);
	echo '</br>';
	//task 2.1
	$x=3.4;
	$alpha=-1.17;
	$m=sqrt(abs($x+$alpha))+17.14*log10(3.14/3);
	$y=$alpha*pow(pow(sin(pow($x,3)),4), 1/3)+12.47;
	$t=log(abs($m-$y))+pow(cos($m * $y), 3);
	echo 'Task 2.1 result: '.$t;
?>