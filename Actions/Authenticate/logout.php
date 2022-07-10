<?PHP
session_start();
session_unset();
session_destroy();

header("Location: ../../Pages/Common/index.php");


?>
