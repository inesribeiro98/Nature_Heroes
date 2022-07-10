<?php
function apply($voluntario_id, $projeto_id, $medical_history, $motivation, $diet, $comment){
  global $conn;

  $query = "INSERT INTO inscricao
            (voluntario_id, projeto_id, medical_history, dieta, motivacao, comentario)
            VALUES ('".$voluntario_id."' , '" .$projeto_id. "', '" .$medical_history."', '".$diet."', '" .$motivation."', '" .$comment."')";

  mysqli_query($conn, $query);

  return $query;
}

function volunteer_in_project($voluntario_id, $projeto_id){ //pagina info do projeto -> verifica se voluntario autenticado está inscrito no projeto em questão
  global $conn;

  $query = "SELECT * FROM inscricao
            WHERE voluntario_id = '".$voluntario_id."'
            AND projeto_id='".$projeto_id."'";

  $result = mysqli_query($conn, $query);

  $num_registos = mysqli_num_rows($result);

  return $num_registos;
}

function get_application($voluntario_id, $projeto_id){
  global $conn;

  $query = "SELECT * FROM inscricao
            WHERE voluntario_id = '".$voluntario_id."'
            AND projeto_id='".$projeto_id."'";

  $result = mysqli_query($conn, $query);

  return $result;
}


function projects_of_volunteer($voluntario_id){ //projetos futuros do voluntário - volunteer main page
  global $conn;

  $query = "SELECT projeto.projeto_id, projeto.nome_projeto, projeto.data_inicio, projeto.data_fim, projeto.foto, cidade.pais, cidade.nome_cidade, cidade.link_gmaps FROM inscricao
            JOIN voluntario ON inscricao.voluntario_id = voluntario.voluntario_id
            JOIN projeto ON inscricao.projeto_id = projeto.projeto_id
            JOIN cidade ON projeto.cidade_id = cidade.cidade_id
            WHERE voluntario.voluntario_id = '".$voluntario_id."'
            AND projeto.data_inicio>'".date('Y-m-d')."'
            ORDER BY data_inicio ASC";

  $result = mysqli_query($conn, $query);

  return $result;
}

function past_projects($voluntario_id){ //projetos passados do voluntário - volunteer main page
  global $conn;

  $query = "SELECT projeto.projeto_id, projeto.nome_projeto, projeto.data_inicio, projeto.data_fim, projeto.foto, cidade.pais, cidade.nome_cidade, cidade.link_gmaps FROM inscricao
            JOIN voluntario ON inscricao.voluntario_id = voluntario.voluntario_id
            JOIN projeto ON inscricao.projeto_id = projeto.projeto_id
            JOIN cidade ON projeto.cidade_id = cidade.cidade_id
            WHERE voluntario.voluntario_id = '".$voluntario_id."'
            AND projeto.data_inicio<='".date('Y-m-d')."'
            ORDER BY data_inicio DESC";

  $result = mysqli_query($conn, $query);

  return $result;
}

function cancel_application($voluntario_id,$projeto_id){
  global $conn;

  $query = "DELETE FROM inscricao WHERE voluntario_id='".$voluntario_id."' AND projeto_id='".$projeto_id."'";

  $result = mysqli_query($conn, $query);

  return $result;
}

function numero_inscricoes_em_projeto($projeto_id){
  global $conn;

  $query = "SELECT * FROM inscricao
            WHERE projeto_id = '".$projeto_id."'";

  $result = mysqli_query($conn, $query);

  $num_registos = mysqli_num_rows($result);

  return $num_registos;
}
 ?>
