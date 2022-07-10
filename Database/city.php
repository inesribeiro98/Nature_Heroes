<?php

function getAllCities(){

  global $conn;

  $query = "SELECT * from cidade";

  $result = pg_exec($conn,$query);

  return $result;
}

 ?>
