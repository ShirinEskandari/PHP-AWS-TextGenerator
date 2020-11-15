<?php
require "./vendor/predis/predis/autoload.php";
/**
 * 
 * This Project is a text generator with the text of Shakespear
 * it gets number of characters 3,6,10 and generates keys and 
 * their next characters frequencies and get probability of each them 
 * and makes a text like a poem 
 * @author Shirin, Suzan
 * @since 2019-10-04
*/
//connects to the Redis Database
Predis\Autoloader::register(); 
try {   
      $redis = new Predis\Client( 
         [ "scheme" => "tcp", 
          "host" => "localhost",   
          "port" => 6379] ); 
    echo "running  ".$redis->ping(). "\n";
    
    fillRedis(3);
    fillRedis(6);
    fillRedis(10);
    

} catch (Exception $e){
     //Note: bad practice to catch general exception, but you are exiting  
   // error_log('error with Redis '. $e->getMessage() ); 
}
/**
 * it gets number of characters 3,6,10 and generates keys and 
 * their next characters frequencies and get probability of each them 
 * 
 * @param $numberOfChars;
 */
function fillRedis($numberOfChars){
    global $redis;
    $text = file_get_contents('shakespeare_input.txt');
    $keySets = getKeys($text, $numberOfChars);
    getProbability($keySets);
    
    echo count($keySets);
    echo PHP_EOL;
    
    foreach ($keySets as $key => $value) {
        $redis->set($key, $value);

    }}

/**it gets all keys on base of the number of characters and the same time
 *counts the number of next characters, if there is the same character it adds to the
 *previous count. if the first time, it gives 1 to it 
 * @param $text the text 
 * @param $numberOfChars number of characters we want to find
 * @return $keySets an array containing  keys and chars
*/

function getKeys($text, $numberOfChars)
{
    $keySets = [];

    for ($i = 0; $i < strlen($text) - $numberOfChars; $i++) {
        $subString = substr($text, $i, $numberOfChars);
        if (!isset($keySets[$subString])) {
            $keySets[$subString] = [];
        }

        $charCount = substr($text, $i + $numberOfChars, 1);
        if (isset($keySets[$subString][$charCount])) {
            $keySets[$subString][$charCount]++;
        } else {
            $keySets[$subString][$charCount] = 1;
        }
    }
    return $keySets;
}
/**
 * it sums all counts of the next characters and devides each counts of each character 
 * to total counts, and gets their probability
 * @param $KeySets
 */
function getProbability(&$keySets)
{
    foreach ($keySets as $k => $v) {
        $sum = array_sum($v);
        foreach ($v as $char => $charCount) {
            $keySets[$k][$char] = $charCount / $sum;
        }

        $keySets[$k] = json_encode($keySets[$k]);
    }
}


