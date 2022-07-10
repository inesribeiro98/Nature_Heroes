<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/feedback.php";

    $testemunho     = $_POST["testemunho"];
    $projeto_id     = $_POST["projeto_id"];

  $result =  create_feedback($testemunho, $projeto_id);

  header('Location: ../../Pages/Volunteer/volunteer_main_page.php');
  ?>
