<!DOCTYPE html>
<?php
  session_start();

  include "../../Includes/opendb.php";
  include "../../Database/volunteer.php";

  $erro="";

  if (!empty($_SESSION['msg_erro'])) {
    $erro = true;
    $_SESSION['msg_erro'] = NULL;
  }
  else {
    $erro = false;
  }
?>

<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../CSS/stylesheet.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In</title>
    <link rel="icon" type="image/png" href="../../Images/Logo.png"/>
</head>

<body>

  <div class="caixa">

  <!-- header -->
  <?php
    include "../../Includes/header.php";
  ?>

  <!-- Projetos  -->

  <div class="whitepart">

      <div class="flexcontainer">
        <div>
          <img src="../../Images/girlnature.jpg">
        </div>
        <div>
          <div id="div_login">
          <form action="../../Actions/Authenticate/login.php" method="post"> <!-- Se nao existir aparece borda vermelha no campo -->
            <label class="label_login">E-mail:</label>
            <input type="email" name="email" <?php if ($erro) echo 'style= "border: 1.5px solid red;"'; ?>>
            <br>
            <br>
            <label class="label_login">Password:</label>
            <input type="password" name="password" <?php if ($erro) echo 'style= "border: 1.5px solid red;"'; ?>>
            <br>
            <br>
            <input id="login" type="submit" value="Login">
          </form>
          </div>
        </div>
      </div>

      <div class="flexcontainer3"> <!-- Logins a ser utilizados como teste para o avaliador -->
        <div> <label class="label_white"> Login as: <br><br> Email:        <br> Password: </label></div>
        <div> <label class="label_white"> Volunteer <br><br> vol@gmail.com <br> volunteer </label></div>
        <div> <label class="label_white"> Manager   <br><br> man@gmail.com <br> manager   </label></div>
      </div>

      <h2> Not a Nature Hero yet? Sign up <a class="log" href="../Common/form_signup.php">here</a>! </h2>

  </div>

  <!-- Footer -->
  <?php
    include "../../Includes/footer.php";
  ?>
  </div>
</body>
</html>
