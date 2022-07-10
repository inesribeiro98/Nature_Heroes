<?php

function getAllCities(){

  global $conn;

  $query = "SELECT * from cidade";

  $result = mysqli_query($conn, $query);

  return $result;
}

 ?>
