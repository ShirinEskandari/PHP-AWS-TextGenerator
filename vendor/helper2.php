<?php
function getAllSubStringsByLength1($content, $length)
 {
   $charArray;
   $firstarr2;
   $strLength = strlen($content);
    for ($i = 0; $i < $strLength; $i++) 
    {
       if(ord($content[$i]) == 13)
       {
        $content[$i] ="\n";
       }
        $charArray[$i] = $content[$i];
    }
    for ($i = 0; $i < count($charArray); $i++)
     {
       $currentSubstringArray = array_slice($charArray, $i, $length);  
       $currenSubString = implode( '',$currentSubstringArray);
       $currenSubString = str_replace("\n","\\n",$currenSubString);
        if (strlen($currenSubString) == $length || strlen($currenSubString) == $length+1) 
        {
         $firstarr= myfunc($currenSubString,$length);
          foreach($firstarr as $value)
          {
           $firstarr2[$currenSubString]=$value;
          }
        }
    }
    return $firstarr2;
}


function func4probability($arr2)
{
 $arr;
 foreach ($arr2 as $key1 => $value)
 {
  $sum1 = funcprob($value);
  foreach ($value as $key => $val)
  {
    $val2        = $val / $sum1;
    $freqq[$key] = $val2;
    $arr[$key1]  = $freqq;
  } 
  unset($freqq);
 }
 return $arr;
}

function funcprob($value)
{
 $sum = 0;
 foreach ($value as $aa)
 {
  $sum = $sum + $aa;
 } //$value as $aa
 return $sum;
}

 
function myfunc($currenSubString,$length)
{
 $firstarr=[];
 static $cont=0;

 $file = fopen("testtext.txt", "r");
  while (!feof($file))
 {
  $firstLine = fgetcsv($file);
  foreach ($firstLine as $line)
   {
    $line = $line."\\n";
 
    while (strpos($line, $currenSubString) !== false)
    {
 
    $intpos   = strpos($line, $currenSubString);
  
    $nextchar = substr($line, $intpos + $length, 1);
   
    if (isset($firstarr[$currenSubString]))
    {
      
     if (!isset($frequency[$nextchar]))
     {
      $count                                  = 1;
      $frequency[$nextchar]                   = $count;
      $firstarr[substr($line, $intpos, $length)] = $frequency;
     } //!isset($frequency[$nextchar])
     else
     { 
      $count                                  = myfun3($firstarr, $currenSubString, $nextchar);
      $frequency[$nextchar]                   = $count + 1;
      $firstarr[substr($line, $intpos, $length)] = $frequency;
     }
    } 
    else
    {
     $count                                  = 1;
     $frequency[$nextchar]                   = $count;
     $firstarr[substr($line, $intpos, $length)] = $frequency;
    }
    $line = substr($line, $intpos + $length);
    } 
    }
    }
    fclose($file);
    $cont++;
   return $firstarr;
  }
  function myfun3($firstarr, $currenSubString, $nextchar)
 {
 foreach ($firstarr as $value)
 {
  foreach ($value as $key => $value2)
  {
    if ($key === $nextchar)
    {
    return $value2;
    } 
  }
 } 
}
?>