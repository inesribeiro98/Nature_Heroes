<?php
session_start();
include "../../Includes/opendb.php";
include "../../Database/feedback.php";

$projeto_id    = $_POST["projeto_id"];
$voluntario_id = $_POST["voluntario_id"];

if (!empty($_POST["accept"])) {
  $aceite = "true";

}
elseif (!empty($_POST["reject"])) {
  $aceite = "false";

}

approve($projeto_id,$voluntario_id,$aceite);

header("Location: ../../Pages/Manager/manage_feedback.php");
?>
