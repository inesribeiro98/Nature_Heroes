<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/project.php";
  include "../../Database/application.php";

  /*se cancelado*/
  if (!empty($_POST['cancelar'])) {
    header("Location: ../../Pages/Manager/list_projects.php");
  }

  /*se não cancelado*/
  if (!empty($_POST['submit'])) {
    $max_participantes  = $_POST["max_participantes"];
    $descricao          = $_POST["descricao"];
    $highlight1         = $_POST["highlight1"];
    $highlight2         = $_POST["highlight2"];
    $highlight3         = $_POST["highlight3"];
    $projeto_id         = $_POST["projeto_id"];

    $erro                 = false;
    $mensagem             = "";
    $_SESSION['msg_erro'] = "";

      /*campos mandatory não podem estar vazios*/
      if (empty($max_participantes) ||  empty($descricao)){
        $erro     = true;
        $mensagem = "Please insert all mandatory fields. ";
      }

      /*nao pode por menos pax do que os que ja estão inscritos*/
      $num_registos = numero_inscricoes_em_projeto($projeto_id);

      if ($num_registos>$max_participantes){
        $erro                = true;
        $mensagem           .="Number of maximum participants not valid. There are already ".$num_registos." participants enrolled in this project";
      }

      if ($erro){
        /*mensagem de erro*/
        $_SESSION['msg_erro']         = $mensagem;

        /*recupera valores do form*/
        $_SESSION['max_participantes'] = $max_participantes;
        $_SESSION['descricao']         = $descricao ;
        $_SESSION['highlight1']        = $highlight1 ;
        $_SESSION['highlight2']        = $highlight2;
        $_SESSION['highlight3']        = $highlight3 ;

         header('Location: ../../Pages/Manager/form_edit_project.php?edit_id='.$projeto_id);
      }
      else {

          edit_project($projeto_id, $max_participantes, $descricao, $highlight1, $highlight2,  $highlight3);

          header('Location: ../../Pages/Manager/list_projects_manager.php');
      }
  }
?>
