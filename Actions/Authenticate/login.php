<?php

	session_start();
  include "../../Includes/opendb.php";
  include "../../Database/volunteer.php";

	$email 		= $_POST['email'];
 	$password = $_POST['password'];

	$result 			= verify_login($email, $password);

	$num_registos = pg_numrows($result);

	if($num_registos>0){
		
		$row=pg_fetch_assoc($result);

		$_SESSION["id"]   		= $row["voluntario_id"];
		$_SESSION["nome"]			= $row["nome"];
		$_SESSION["msg_erro"]	= NULL;

			if ($row["voluntario_id"]==6){  //gerente
				header("Location: ../../Pages/Manager/list_projects_manager.php");
			}
			else { //voluntario

					if (isset($_SESSION["origem_projeto"])){
						header("Location: ../../Pages/Volunteer/form_apply_to_project.php?id=".$_SESSION["origem_projeto"]);
					}
					else {
						header("Location: ../../Pages/Volunteer/volunteer_main_page.php");
					}
			}

	}
	else { //erro
			$_SESSION["msg_erro"] = "That combination of email and password is not valid.";
			header("Location: ../../Pages/Common/form_login.php");
	}
?>
