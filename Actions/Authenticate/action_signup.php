<?php
session_start();
include "../../Includes/opendb.php";
include "../../Database/volunteer.php";

//se carregar em Cancel//
if (!empty($_POST['cancel'])) {
  header("Location: ../../Pages/Common/index.php");
}

//se carregar em submit//
if (!empty($_POST['submit'])) {

  $name            = $_POST["name"];
  $email           = $_POST["email"];
  $password        = $_POST["password"];
  $phone_number    = $_POST["phone_number"];
  $nationality     = $_POST["nationality"];
  $passport_number = $_POST["passport_number"];

  $erro            = false;
  $mensagem        = "";

  $_SESSION['msg_erro'] = "";


  //1. todos os campos sao de preenchimento obrigatório//
      if (empty($name) || empty($email) || empty($password) ||  empty($phone_number) ||  empty($nationality) ||  empty($passport_number)){
        $erro     = true;
        $mensagem = "Please insert all mandatory fields.";
      }

  //2. nao se pode criar uma conta se o email já tiver uma conta associada//
    $num_registos = check_email($email);
    if($num_registos > 0){
      $erro     =true;
      $mensagem = "That e-mail is already associated with an account. Please choose another one.";
      $_SESSION["erro_email"] = "true";
      }

      //se deu erro
    if ($erro) {
        /*mensagem de erro*/
      $_SESSION['msg_erro']        = $mensagem;

      //manter tudo preenchido//
      $_SESSION['name']            = $name;
      $_SESSION['email']           = $email;
      $_SESSION['password']        = $password;
      $_SESSION['phone_number']    = $phone_number;
      $_SESSION['nationality']     = $nationality;
      $_SESSION['passport_number'] = $passport_number;

      header('Location: ../../Pages/Common/form_signup.php');

    }
    else {
        create_volunteer($name,$email,$password,$phone_number,$nationality,$passport_number);

        $result = verify_login($email,$password);
        $row    = pg_fetch_assoc($result);

    		$_SESSION["id"]   		= $row["voluntario_id"];
    		$_SESSION["nome"]			= $row["nome"];
        $_SESSION["msg_erro"]	= NULL;

  					if (isset($_SESSION["origem_projeto"])){
          		header("Location: ../../Pages/Volunteer/form_apply_to_project.php?id=".$_SESSION["origem_projeto"]);
  					}
            else {
  					  header("Location: ../../Pages/Common/index.php");
  					}
      }
  }
?>
