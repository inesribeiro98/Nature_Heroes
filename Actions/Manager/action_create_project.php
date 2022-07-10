<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/project.php";

  /*se cancelado*/
  if (!empty($_POST['cancelar'])) {
    header("Location: ../../Pages/Manager/select_project_create_method.php");
  }

  /*se não cancelado*/
  if (!empty($_POST['criar'])) {
      $nome_projeto       = $_POST["nome_projeto"];
      $cidade_id          = $_POST["cidade_id"];
      $data_inicio        = $_POST["data_inicio"];
      $data_fim           = $_POST["data_fim"];
      $max_participantes  = $_POST["max_participantes"];
      $descricao          = $_POST["descricao"];
      $requirements       = $_POST["requirements"];
      $highlight1         = $_POST["highlight1"];
      $highlight2         = $_POST["highlight2"];
      $highlight3         = $_POST["highlight3"];
      $foto               = "";

      $erro                 = false;
      $mensagem             ="";
      $_SESSION['msg_erro'] = "";


      /*campos mandatory não podem estar vazios*/
      if (empty($nome_projeto) || empty($cidade_id) || empty($data_inicio) ||  empty($data_fim) ||  empty($max_participantes) ||  empty($descricao)){
        $erro     = true;
        $mensagem = "Please insert all mandatory fields. ";
      }

      /*duração minima do projeto de uma semana*/
      if (!empty($data_inicio) && !empty($data_fim)){
        $date1_ts = strtotime($data_inicio);
	      $date2_ts = strtotime($data_fim);
	      $diff     = $date2_ts - $date1_ts;
	      $duracao  = round($diff / 86400);

        if ($duracao < 7){
            $erro                    = true;
            $_SESSION['erro_duracao']="erro";
            $mensagem                = $mensagem. " The duration of the project is not valid (min duration: 1 week).";
          }
      }

      /*maximo de participantes positivo e pelo menos 1*/
      if (($max_participantes < 1) && !empty($max_participantes)) {
        $erro                 = true;
        $_SESSION['erro_pax'] = "erro";
        $mensagem             = $mensagem. " The maximum participants needs to be at least 1.";
      }

      if ($erro){
        /*mensagem de erro*/
        $_SESSION['msg_erro']          = $mensagem;

        /*recupera valores do form*/
        $_SESSION['nome_projeto']      = $nome_projeto;
        $_SESSION['cidade_id']         = $cidade_id;
        $_SESSION['data_inicio']       = $data_inicio;
        $_SESSION['data_fim']          = $data_fim ;
        $_SESSION['max_participantes'] = $max_participantes;
        $_SESSION['descricao']         = $descricao ;
        $_SESSION['requirements']      = $requirements ;
        $_SESSION['highlight1']        = $highlight1 ;
        $_SESSION['highlight2']        = $highlight2;
        $_SESSION['highlight3']        = $highlight3 ;
        $_SESSION['foto']              = $foto;

      header('Location: ../../Pages/Manager/form_create_project.php');
      } else {

        if (isset($_SESSION["foto_aux"]) && (empty($_FILES["foto"]["name"])) ){ //havia um foto inicial e esta nao foi alterada
            $foto                 = $_SESSION["foto_aux"];
            $_SESSION["foto_aux"] = "";

        } else { //foto inicial foi alterada
            $_SESSION["foto_aux"] = "";

            $prefixo = 'proj_' . date('Y-m-d H:i:s', time()); // definir um prefixo apropriado para identificação
            $foto    = $prefixo . $_FILES["foto"]["name"];
            $foto    = str_replace(' ', '', $foto);//remover os espaços para evitar erros
            $foto    = str_replace(':', '', $foto);//remover os : para evitar erros
            $foto    = str_replace('-', '', $foto);//remover os - para evitar erros
            $destino = '../../Images/Project_images/' . $foto;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);
        }

      create_project($nome_projeto, $cidade_id, $data_inicio, $data_fim, $max_participantes, $descricao, $requirements, $highlight1, $highlight2,  $highlight3, $foto);

      header('Location: ../../Pages/Common/list_projects.php');
      }
  }
?>
