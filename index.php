
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="./style/style.css">
</head>
<body>
<h1>Shakespeare Text Generator</h>
<div class="shakespeareImg">
<img id="shekspearImg" src="./images/5.gif"></img>
</div>
<h3>Create your own shakespeare text</h3>
<div class="formContainer">
<form action="" method="GET">
        <p>Please select the number of characters in the model</p>
        <input type="radio" name="lenght" value="3" checked>3 (default)<br>
  <br>
        <input type="radio" name="lenght" value="6">6<br>
   <br>
        <input type="radio" name="lenght" value="10">10<br>
        <div id = "submitBtn">
        <input  type="submit" name="submit" value="submit" />
        </div>
  <br>
</form>
</div>
<div class="container">
    <img src="./images/23.png" alt="old paper" style="width:100%;">
    <div class="centered">
           <?php 
  include('generate.php');
  if(isset($_GET['submit'])){
    $input = $_GET['lenght'];
    $int = (int)$input;
    $generatedTxt = generateText($int);
    echo nl2br($generatedTxt);
}
?>
    </div>

</img>
</div>
</body>
</html>

