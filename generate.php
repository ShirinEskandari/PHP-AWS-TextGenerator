<?php
/**
 * This Script generate the code from the prepared redis table
 * @author Shirin, Suzan
 * 2019-10-04
 */
require "./vendor/predis/predis/autoload.php";
//$numberOfChars =-1;
Predis\Autoloader::register(); 
try {   
      $redis = new Predis\Client( 
         [ "scheme" => "tcp", 
          "host" => "localhost",   
          "port" => 6379] ); 

} catch (Exception $e){
     //Note: bad practice to catch general exception, but you are exiting  
    error_log('error with Redis '. $e->getMessage() ); 
}
/**
 * It produces random number between 0-1
 * add probability of each character to previouse one 
 * gets the place of each character in the probability between 0-1
 * then it choose which character is in the random number range
 * @param $jsonresult
 * @return $k(character)
 */
 function getNextRandomChar($jsonresult ){
     $random= rand()/getrandmax();
     $arr2=[];
     $k ='';
     $key ='';
     $value='';
     $v='';
        foreach($jsonresult as $key=>$value){
           $va=0;
           $arr2[$key]=$value+$va;
           $va = $value+$va;
        }
        foreach($arr2 as $k=>$v){
         if($random<$v){
            break;
        }
    }
    return $k;
    }
    /**
     * It gets number of characters to generate the text on base of that
     * it gets the value of  number of characters from the redis and with the helper 
     * function, it choses the next character and produce the next key and gets 
     * next characters value from the redis and produces the text and so on
     * 
     * @param $numberofChars
     * @return $generatedstring
     */
    function generateText($numberOfChars){
        global $redis;
        if($numberOfChars === 3){
          $generatedstring = 'Fir';  
        }
         if($numberOfChars === 6){
          $generatedstring = 'First ';  
        }
         if($numberOfChars === 10){
          $generatedstring = 'First Citi';  
        }
        $firstkey = $generatedstring;
         $jsonresult ='';
     while(strlen($generatedstring) <1001){
        $find = $redis->get($firstkey);
        $jsonresult = json_decode($find);
        $nextrandomchar= getNextRandomChar($jsonresult);
        $generatedstring = $generatedstring.$nextrandomchar;
        $firstkey= substr($generatedstring,-3);
        }
        return $generatedstring;
     }

?>