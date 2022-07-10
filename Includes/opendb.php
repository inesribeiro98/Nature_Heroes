<?php
//Conexão com a base de dados

  $conn=new mysqli('sql205.epizy.com', 'epiz_32138881', 'lhwGvqIG35A0l', 'epiz_32138881_natureheroes');


  if(!$conn){
    echo "It was not possible to connect to the database" ;
  }


 ?>
