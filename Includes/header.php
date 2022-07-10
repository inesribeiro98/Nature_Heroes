<!-- Navigation bar -->
<?php
  //Variáveis que controlam o que acontece dependendo do login estar ou nao feito//
  $mensagem="";
  $log="";

  if (isset($_SESSION["id"])){   //Login feito//
    $mensagem="Hey, " .$_SESSION["nome"]. "!";
    if ($_SESSION["id"]==6){
      $log="../../Pages/Manager/list_projects_manager.php";
    } else {
      $log= "../../Pages/Volunteer/volunteer_main_page.php";
    }

  } else { //Login não feito//
    $mensagem="Login!";
    $log="../../Pages/Common/form_login.php";
  }
 ?>
<html>

  <head>
    <link rel="stylesheet" type="text/css" href="../CSS/Stylesheet.css">
    <meta charset="UTF-8">
  </head>

  <ul class="nav">
    <li class="logo" > <a href="../../Pages/Common/index.php" >  <img src="../../Images/Logo.png" alt="logo" style="width:50px;height:50px"> </a> </li>
    <li class="nome" > <a href="../../Pages/Common/index.php" >  <h4>  Nature Heroes </h4> </a> </li>
    <li class="normal"> <a href="<?php echo $log;?>" > <h4> <img class="headicon" src="../../Images/Icons/social.png" alt="login" > <?php echo $mensagem;?> </h4>  </a> </li>
    <li class="normal"> <a href="../../Pages/Common/about.php" > <h4> <img class="headicon" src="../../Images/Icons/circle.png" alt="about" > About Us </h4>  </a> </li>
    <li class="normal">  <a href="../../Pages/Common/list_projects.php"> <h4>  <img class="headicon" src="../../Images/Icons/miscellaneous.png" alt="projects" >  Our Projects </h4> </a> </li>
  </ul>

</html>
