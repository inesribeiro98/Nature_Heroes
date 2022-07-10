<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/application.php";

  /*se cancelado*/
  if (!empty($_POST['cancelar'])) {
      header("Location: ../../Pages/Common/list_projects.php");
  }

  /*se não cancelado*/
  if (!empty($_POST['inscrever'])) {
      $medical_history   = $_POST["medical_history"];
      $motivation        = $_POST["motivation"];
      $diet              = $_POST["diet"];
      $comment           = $_POST["comment"];
      $read              = $_POST["read"];
      $privacy           = $_POST["privacy"];
      $voluntario_id     = $_POST["voluntario_id"];
      $projeto_id        = $_POST["projeto_id"];

      $erro                 = false;
      $mensagem             = "";
      $_SESSION['msg_erro'] = "";

      /*motivação é obrigatorio*/
      if (empty($motivation)){
        $erro     = true;
        $mensagem = "Please tell us your motivation to apply. ";
        echo $mensagem;
      }

      /*tem de aceitar os termos*/
     if (!($read) || !($privacy)){
        $erro     = true;
        $mensagem = $mensagem. "Please agree to the terms and conditions of Nature Heroes.";
      }

      if ($erro){
        /*mensagem de erro*/
        $_SESSION['msg_erro']         = $mensagem;

        /*recupera valores do form*/
        $_SESSION['medical_history']   = $medical_history;
        $_SESSION['motivation']        = $motivation;
        $_SESSION['diet']              = $diet;
        $_SESSION['comment']           = $comment ;
        $_SESSION['read']              = $read;
        $_SESSION['privacy']           = $privacy;

        header("Location: ../../Pages/Volunteer/form_apply_to_project.php?id=".$_SESSION["origem_projeto"]);
      }
      else {
        $result = apply($voluntario_id, $projeto_id, $medical_history, $motivation, $diet, $comment);

        header('Location: ../../Pages/Volunteer/volunteer_main_page.php');
      }
  }
?>
