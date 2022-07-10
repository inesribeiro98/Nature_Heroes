<?php
//Conexão com a base de dados

  $conn=pg_connect("host=db dbname=si2036 user=si2036 password=OUyzUEBC");

  if(!$conn){
    echo "It was not possible to connect to the database" ;
  }

  $query = "set schema 'nature_heroes'";

  pg_exec($conn,$query);

 ?>
