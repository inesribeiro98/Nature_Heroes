<?php
session_start();
include "../../Includes/opendb.php";
include "../../Database/volunteer.php";

//se carregar em cancel//
if (!empty($_POST['cancel'])) {
  header("Location: ../../Pages/Common/index.php");
}

//se carregar em submit//
if (!empty($_POST['submit'])) {

  $name            = $_POST["name"];
  $email           = $_POST["email"];
  $password        = $_POST["password"];
  $phone_number    = $_POST["phone_number"];
  $country         = $_POST["country"];
  $passport_number = $_POST["passport_number"];

  $erro = false;

  $_SESSION['msg_erro'] = "";

  //1 todos os campos sao de preenchimento obrigatório//
    if (empty($name) || empty($email) || empty($password) ||  empty($phone_number) ||  empty($country) ||  empty($passport_number)){
      $erro = "Please fill in all info.";
    }

  //2 nao pode mudar o email para um que ja tenha outra conta associado//
    $result = check_email_edit($email);
    $num_registos = pg_numrows($result);
    $row=pg_fetch_assoc($result);

    if(($num_registos>0) && ($row["voluntario_id"] <> $_SESSION["id"])){
      $erro="Email not valid.";
    }

    // 3 Fases 1 ou 2 deram erro?
    if ($erro) {
        /*mensagem de erro*/
      $_SESSION['msg_erro'] = $erro;

      //manter tudo preenchido//
      $_SESSION['name']            = $name;
      $_SESSION['email']           = $email;
      $_SESSION['password']        = $password;
      $_SESSION['phone_number']    = $phone_number;
      $_SESSION['country']         = $country;
      $_SESSION['passport_number'] = $passport_number;

      header('Location: ../../Pages/Volunteer/volunteer_main_page.php');

    }
    else { //não deu erro
      edit_info($name,$email,$password,$phone_number,$country,$passport_number); //edita info do voluntario

    	$_SESSION["nome"]			= $name; //atualiza nome da sessão
      $_SESSION["msg_erro"]	= NULL;

      header('Location: ../../Pages/Volunteer/volunteer_main_page.php');
      }

  }
?>
