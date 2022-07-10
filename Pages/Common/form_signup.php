<!DOCTYPE html>
<?php
session_start();
include "../../Includes/opendb.php";
include "../../Database/project.php";

$erro_name            = false;
$erro_email           = false;
$erro_password        = false;
$erro_phone_number    = false;
$erro_nationality     = false;
$erro_passport_number = false;

//recuperação de valores, se for o caso (ou seja das variaveis em que nao deu erro)//
if (!empty($_SESSION['msg_erro'] )) {
      if (!empty($_SESSION['name'])){
          $name        = $_SESSION['name'];
      }
      else {
          $erro_name   = true;
          $name        = "";
      }

      if (!empty($_SESSION['email'])){
          $email       = $_SESSION['email'];
      }
      else {
          $erro_email  = true;
          $email       = "";
      }

      if (isset($_SESSION["erro_email"])){ //ja ha um email igual
        $erro_email             = true;
        $_SESSION["erro_email"] = NULL;
      }

      if (!empty($_SESSION['password'])){
          $password      = $_SESSION['password'];
      }
      else {
          $erro_password = true;
          $password      = "";
      }

      if (!empty($_SESSION['phone_number'])){
          $phone_number      = $_SESSION['phone_number'];
      }
      else {
          $erro_phone_number = true;
          $phone_number      = "";
      }


      if (!empty($_SESSION['nationality'])){
          $nationality = $_SESSION['nationality'];
      }
      else {
          $erro_nationality = true;
          $nationality      = "";
      }

      if (!empty($_SESSION['passport_number'])){
          $passport_number      = $_SESSION['passport_number'];
      }
      else {
          $erro_passport_number = true;
          $passport_number      = "";
      }

}
else {
    $name            = "";
    $email           = "";
    $password        = "";
    $phone_number    = "";
    $nationality     = "";
    $passport_number = "";
}

$_SESSION['name']             = NULL;
$_SESSION['passport_number']  = NULL;
$_SESSION['nationality']      = NULL;
$_SESSION['phone_number']     = NULL;
$_SESSION['password']         = NULL;
$_SESSION['email']            = NULL;
?>

<html>

  <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" type="text/css" href="../../CSS/stylesheet.css">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Sign up</title>
      <link rel="icon" type="image/png" href="../../Images/Logo.png"/>

      <script type="text/javascript" src="../../Javascript/javascript.js"> </script>
  </head>

<body>
  <div class="caixa">
    <!-- header -->
    <?php
      include "../../Includes/header.php";
    ?>

    <div class="whitepart">

      <h2>One step away from becoming part of the Nature Hero community!</h2>

      <div id="texto_signup">

        <p>Please fill in your personal information in the fields below.</p>
        <br>

        <!--mensagem de erro-->
        <?php
        if (!empty($_SESSION['msg_erro'] )) {
          echo "<p class ='aviso'> ".$_SESSION['msg_erro']."<p>";
          $_SESSION['msg_erro'] = NULL;
        }
        ?>

        <form action="../../Actions/Authenticate/action_signup.php" method="post">
          <label class="label_signup">Name:</label>
          <input type="text" name="name" value ="<?php echo $name; ?>" class="signup" style="<?php if ($erro_name){ echo 'border: 1.5px solid red;';} ?>" />
          <br>
          <label class="label_signup" >Phone number:</label>
          <input type="text" name="phone_number" value ="<?php echo $phone_number; ?>" class="signup" style="<?php if ($erro_phone_number){ echo 'border: 1.5px solid red;';} ?>" />
          <br>
          <label class="label_signup" >Email:</label>
          <input type="email" name="email" value ="<?php echo $email; ?>" class="signup" style="<?php if ($erro_email){ echo 'border: 1.5px solid red;';} ?>" />
          <br>
          <label class="label_signup" >Password:</label>
          <input type="password" name="password" onkeydown="validaPassword(this.value)" value ="<?php echo $password; ?>"class="signup"  style="<?php if ($erro_password){ echo 'border: 1.5px solid red;';} ?>" />

          <span id="msg"></span>
          <br>
          <div id="out-div" >
            <div id="in-div"> </div>
          </div>

          <label class="label_signup" >Country:</label>
          <input type="text" name="nationality" value ="<?php echo $nationality; ?>" class="signup" style="<?php if ($erro_nationality){ echo 'border: 1.5px solid red;';} ?>" />
          <br>
          <label class="label_signup">Passport Number:</label>
          <input type="text" name="passport_number" value ="<?php echo $passport_number; ?>" class="signup" style="<?php if ($erro_passport_number){ echo 'border: 1.5px solid red;';} ?>" />
          <br>
          <br>
          <input type="submit" name="cancel" value="Cancel" class="signup" style="margin-left:175px;">
          <input type="submit" name="submit" value="Submit!" class="signup">
        </form>

        <img class="img_signup" src="../../Images/volunteer-workers.JPG">

      </div>

    </div>

    <!-- Footer -->
    <?php
      include "../../Includes/footer.php";
     ?>
  </div>

</body>
</html>
