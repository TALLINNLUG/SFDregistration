<!DOCTYPE HTML>  
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  



<?php
// Based on examples from
// http://www.w3schools.com/php
// http://myphpform.com
// http://stackoverflow.com/questions/7711466/checking-if-form-has-been-submitted-php
// http://stackoverflow.com/questions/7266935/how-to-send-utf-8-email#7267251
// Further interesting example
// http://code.tutsplus.com/tutorials/how-to-implement-email-verification-for-new-members--net-3824

// define variables and set to empty values

$nameErr = $emailErr = $tutorialErr = $ageErr = $computerErr = "";
$name = $email = $tutorial =  $age = $computer = $comment =  "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Nimi on vajalik / Требуется имя / Name is required";
  } else {
    $name = test_input($_POST["name"]);
  } 
  
  if (empty($_POST["email"])) {
    $emailErr = "e-posti on valjak / Требуется адрес электронной почты /email is required";
  } else {
    $email = test_input($_POST["email"]);
  }
    
  if (empty($_POST["tutorial"])) {
    $tutorialErr = "Õppetund valik on vajalik / Выбор обязателен / Tutorial choice is required";
  } else {
    $tutorial = test_input($_POST["tutorial"]);
  }

  if (empty($_POST["computer"])) {
    $computerErr = "Arvuti olemasolu vajalik / Требуется наличие компьютера / Computer availability required";
  } else {
    $computer = test_input($_POST["computer"]);
  }

  if (empty($_POST["age"])) {
    $tutorialErr = "Õppetund valik on vajalik / Требуется указать возраст / Age is required";
  } else {
    $age = test_input($_POST["age"]);
  }

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<h2>SFD Tallinn 2017</h2>

<p><span class="error">* nõutud väli / обязательное поле / required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  nimi / имя / name:<br />
  <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  e-post / эл. адрес / email:<br />
  <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  vanas / возраст / age:<br />
  <input type="radio" name="age" <?php if (isset($age) && $age=="3-7") echo "checked";?> value="3-7">3-7<br />
  <input type="radio" name="age" <?php if (isset($age) && $age=="8-11") echo "checked";?> value="8-11">8-11<br />
  <input type="radio" name="age" <?php if (isset($age) && $age=="12-16") echo "checked";?> value="12-16">12-16<br />
  <input type="radio" name="age" <?php if (isset($age) && $age=="16+") echo "checked";?> value="16+">16+
  <span class="error">* <?php echo $tutorialErr;?></span><br><br>
  õppetund / урок / tutorial:<br />
  <input type="radio" name="tutorial" <?php if (isset($tutorial) && $tutorial=="Digitaalne joonistamine  /
 Цифровая живопись / Digital painting") echo "checked";?> value="Digitaal
ne joonistamine / Цифровая живопись / Digital painting ">Digitaalne joonistamine / Цифровая живопись / Digital painting<br />
  <input type="radio" name="tutorial" <?php if (isset($tutorial) && $tutorial=="Avatud tarkvara / Открытое программное обеспечение / Open source software") echo "checked";?> value="Avatud tarkvara / Открытое программное обеспечение / Open Software">Avatud tarkvara / Открытое программное обеспечение / Open software
  <span class="error">* <?php echo $tutorialErr;?></span>
  <br><br>
  Saan tuua oma arvuti / Я могу взять мой собственный компьютер / I can bring my own computer:<br />
  <input type="radio" name="computer" <?php if (isset($computer) && $computer=="Yes") echo "checked";?> value="Yes">jah 
/ да / yes
  <input type="radio" name="computer" <?php if (isset($computer) && $computer=="No") echo "checked";?> value="No">ei / Н
ет / no
  <span class="error">* <?php echo $computerErr;?></span>
  <br><br>
  kommentaar / комментарий / comment:<br />
  <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
  <br><br>
  juurdepääsukood / код доступа / access code:<br />
  <input type="text" name="code" /><br />
  Palun sisesta <b>ANIMATSIO0N</b> eespool. / Пожалуйста, введите <b>ANIMATS1O0N</b> выше. / Please enter <b>ANIMATS1O0N</b> above. <br
 />
  <br><br>
  <input type="submit" name="formsubmit" value="Saada / Отправить / Submit"/>  

</form>



<?php
// Check for submission of entered data
if (isset($_POST['formsubmit'])){
 // Check for spam prevention code entry
 if (strtolower($_POST['code']) != 'animatsioon' ) {die('vale koodi / неверный код доступа / Wrong access code');}
  else{ 
   // Set e-mail recipient 
   $myemail  = "koosolek@eestikohtuma.info";

   // Set subject 
   $subject = "Tallinn avatud tarkvara";

   // Let's prepare the message for the e-mail 
   $message = "

   nimi / имя / name, $name ,
   e-post / эл. адрес / email, $email ,
   vanas / возраст / age, $age ,
   õppetund / тема / tutorial, $tutorial
   tuua arvuti / принести компьютер / bring computer, $computer ,
   kommentaarid / комментарии / comments, $comment ,

   ";
   // Ensure have language encoding support
   $headers ="From: koosolek@eestikohtuma.info\r\nCC: ".$email."\r\nContent-Type: text/html; charset=UTF-8";

   // Send the message using mail() function 
   mail($myemail, $subject, $message, $headers);
   // Give user feedback 
   echo "<h2>Teie panus / Ваши данные / Your input:</h2>";
   echo $name;
   echo "<br>";
   echo $email;
   echo "<br>";
   echo $age;
   echo "<br>";
   echo $tutorial;
   echo "<br>";
   echo $computer;
   echo "<br>";
   echo $comment;
   echo "<br>";
   echo "On esitatud, siis peaks saama kinnituse 1 tööpäeva jooksul";
   echo "<br>";
   echo "Отправлено, вы должны получить подтверждение в течение 1 рабочего дня";
   echo "<br>";
   echo "Has been submitted, you should receive an acknowledgement within 1 working day";
   echo "<br>";
 }
}
?>

</body>
</html>
