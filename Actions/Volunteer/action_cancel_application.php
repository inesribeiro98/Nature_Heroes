<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/application.php";

  $projeto_id    = $_GET["id"];
  $voluntario_id = $_SESSION["id"];
  
  cancel_application($voluntario_id,$projeto_id);

  header('Location: ../../Pages/Volunteer/volunteer_main_page.php');
 ?>
