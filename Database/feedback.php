<?php
function create_feedback($testemunho, $projeto_id){
  global $conn;

  $query = "INSERT INTO testemunho
            (voluntario_id, projeto_id, testemunho)
            VALUES ('".$_SESSION["id"]."', '" .$projeto_id. "', '" .$testemunho."')";

  $result = mysqli_query($conn, $query);

}

function search_feedback($projeto_id){ //pagina principal do voluntario
  global $conn;

  $query = "SELECT * FROM testemunho
            WHERE voluntario_id='".$_SESSION["id"]."'
            AND projeto_id ='".$projeto_id."'";

  $result = mysqli_query($conn, $query);

  $num_registos = mysqli_num_rows($result);

  return $num_registos;
}

function feedback_from_city($cidade_id){ //pagina info o projeto, para mostrar feedbacks
  global $conn;

  $query = "SELECT testemunho.testemunho, voluntario.nome, projeto.nome_projeto, projeto.data_inicio, projeto.data_fim, projeto.foto
            FROM testemunho
            LEFT JOIN projeto ON testemunho.projeto_id = projeto.projeto_id
            LEFT JOIN voluntario ON testemunho.voluntario_id = voluntario.voluntario_id
            LEFT JOIN cidade ON projeto.cidade_id = cidade.cidade_id
            WHERE cidade.cidade_id='".$cidade_id."'
            AND aprovado_yn='true'";

  $result = mysqli_query($conn, $query);

  return $result;
}

function feedbacks_to_approve(){ //procura todos os feedbacks para aprovar
  global $conn;

  $query = "SELECT * FROM testemunho, projeto
            WHERE projeto.projeto_id= testemunho.projeto_id
            AND aprovado_yn=''";

  $result = mysqli_query($conn, $query);

  return $result;
}

function approve($projeto_id,$voluntario_id,$aceite){ //aprova/rejeita feedback
  global $conn;

  $query = "UPDATE testemunho
          SET aprovado_yn='".$aceite."'
          WHERE voluntario_id='".$voluntario_id."'
          AND projeto_id='".$projeto_id."'";

  mysqli_query($conn, $query);
}

?>
