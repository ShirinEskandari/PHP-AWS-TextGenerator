<?php
require "./vendor/predis/predis/autoload.php";
require "helper2.php";

Predis\Autoloader::register(); 
 try {   
      $redis = new Predis\Client( 
         [ "scheme" => "tcp", 
         "host" => "localhost",   
         "port" => 6379] ); 
    echo "running  ".$redis->ping(). "\n";
$filename = "testtext.txt";
$arr1;
$length=3;
$content="";
$content = file_get_contents($filename);
$arr1= getAllSubStringsByLength1(file_get_contents($filename),3);
$arr2;
 $freq ;
 foreach ($arr1 as $key1 => $value)
 {
  foreach ($value as $key => $value2)
  {
    $freq[$key]  = $value2;
    $arr2[$key1] = $freq;  
   } 
   unset($freq);
  } 
 
     foreach($arr2 as $value){
     $subseqprobability = func4probability($arr2);  
     foreach ($subseqprobability as $key => $value)
 { 
    $json=json_encode($value);
    $redis->set($key,$json);
 }
     }
  } catch (Exception $e){
    //Note: bad practice to catch general exception, but you are exiting  
    error_log('error with Redis '. $e->getMessage() ); 
    exit; } 

?>