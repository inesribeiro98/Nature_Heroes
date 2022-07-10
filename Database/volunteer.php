<?php

function create_volunteer($name,$email,$password,$phone_number,$nationality,$passport_number){
  global $conn;

  $query = "INSERT INTO voluntario (nome,email,password,telemovel,nacionalidade,bilhete_identidade)
            VALUES ('".$name."', '".$email."', '".$password."','".$phone_number."', '". $nationality."','".$passport_number."')";

  pg_exec($conn, $query);
}


function check_email($email){
  global $conn;

  $query = "SELECT *
            FROM voluntario
            WHERE voluntario.email = '".$email."'";

  $result = pg_exec($conn,$query);

  $num_registos = pg_numrows($result);

  return $num_registos;
}


function check_email_edit($email){
  global $conn;

  $query = "SELECT voluntario_id
            FROM voluntario
            WHERE voluntario.email = '".$email."'";

  $result = pg_exec($conn,$query);

  return $result;
}


function get_volunteer_info($volunteer_id){
  global $conn;

  $query = "SELECT *
            FROM voluntario
            WHERE voluntario_id = '".$volunteer_id."'";

  $result = pg_exec($conn,$query);

  return $result;
}


function verify_login($email,$password){
  global $conn;

  $query = "SELECT voluntario_id,nome
            FROM voluntario
            WHERE email='".$email."'
            AND password='".$password."'";

  $result = pg_exec($conn, $query);

  return $result;
}


function edit_info($name,$email,$password,$phone_number,$country,$passport_number){ //volunteer main page
  global $conn;

  $query = "UPDATE voluntario
            SET nome='". $name."',
                email='".$email."',
                password='".$password."',
                telemovel='".$phone_number."',
                bilhete_identidade ='".$passport_number."',
                nacionalidade ='".$country."'
            WHERE voluntario_id=".$_SESSION["id"] ;

  pg_exec($conn, $query);
}


function get_all_volunteers($pais,$nome,$projects_yn){
  global $conn;

  $query = "SELECT voluntario.voluntario_id, voluntario.nome, voluntario.email,voluntario.nacionalidade, voluntario.telemovel
            FROM voluntario
            LEFT JOIN inscricao ON voluntario.voluntario_id = inscricao.voluntario_id";

  if ($projects_yn){
    $query.= " WHERE voluntario.voluntario_id=inscricao.voluntario_id";
  }

  $query.= " GROUP BY voluntario.voluntario_id HAVING 1=1";

  if (!empty($pais)){
    $query.= " AND voluntario.nacionalidade='".$pais."'";
  }

  if (!empty($nome)){
    $query.= " AND voluntario.nome='".$nome."'";
  }

  $result = pg_exec($conn, $query);

  return $result;
}


function get_all_countries(){
  global $conn;

  $query = "SELECT nacionalidade
          FROM voluntario
          GROUP BY nacionalidade
          ORDER BY nacionalidade ASC";

  $result = pg_exec($conn, $query);

  return $result;
}


function get_enrolled_projects($voluntario_id){
  global $conn;

  $query = "SELECT inscricao.projeto_id, projeto.nome_projeto
            FROM inscricao, voluntario, projeto
            WHERE inscricao.voluntario_id = voluntario.voluntario_id
            AND inscricao.voluntario_id = '".$voluntario_id."'
            AND inscricao.projeto_id = projeto.projeto_id";

  $result = pg_exec($conn, $query);
  
  return $result;
}

 ?>
