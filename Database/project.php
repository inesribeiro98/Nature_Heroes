<?php

function get_all_projects_manager($spot_yn, $pais,$nome_projeto,$sort){ //pagina list projects
  global $conn;

  $query ="SELECT projeto.projeto_id, projeto.nome_projeto, projeto.max_participantes, projeto.data_inicio, projeto.data_fim, cidade.nome_cidade, cidade.pais, COUNT(inscricao.projeto_id) AS \"ocupadas\"
          FROM projeto
          LEFT JOIN inscricao ON projeto.projeto_id = inscricao.projeto_id
          LEFT JOIN cidade ON projeto.cidade_id=cidade.cidade_id
          GROUP BY projeto.projeto_id, cidade.cidade_id
          HAVING 1=1";

  if ($spot_yn){
    $query.= " AND COUNT(inscricao.projeto_id) < projeto.max_participantes ";
  }

  if (!empty($pais)){
    $query.= " AND cidade.pais='".$pais."'";
  }

  if (!empty($nome_projeto)){
    $query.= " AND projeto.nome_projeto='".$nome_projeto."'";
  }

  $query.= $sort;

  $result = mysqli_query($conn, $query);

  return $result;
  }


function edit_project($projeto_id, $max_participantes, $descricao,$highlight1, $highlight2,  $highlight3){
  global $conn;

  $query = "UPDATE projeto
          SET max_participantes='". $max_participantes."',
          descricao='".$descricao."',
          highlight1='".$highlight1."',
          highlight2='".$highlight2."',
          highlight3 ='".$highlight3."'
          WHERE projeto_id='".$projeto_id."'";

  $result = mysqli_query($conn, $query);
}


function get_all_projects_manager2($pais,$nome_projeto){ //pagina create project method (selecionar projeto base)
  global $conn;

  $query ="SELECT projeto.projeto_id, projeto.nome_projeto, cidade.nome_cidade, cidade.pais, projeto.data_inicio, projeto.data_fim
          FROM projeto
          LEFT JOIN cidade ON projeto.cidade_id=cidade.cidade_id
          GROUP BY cidade.cidade_id, projeto.projeto_id
          HAVING 1=1";

  if (!empty($pais)){
    $query.= " AND cidade.pais='".$pais."'";
  }

  if (!empty($nome_projeto)){
    $query.= " AND projeto.nome_projeto='".$nome_projeto."'";
  }

  $query.= " ORDER BY cidade.cidade_id, nome_projeto ASC";

  $result = mysqli_query($conn, $query);

  return $result;
}



function get_volunteers_project($projeto_id, $pais, $nome){
  global $conn;

  $query = "SELECT inscricao.voluntario_id, projeto.nome_projeto, voluntario.nome, voluntario.email, voluntario.telemovel, voluntario.nacionalidade, voluntario.voluntario_id
          FROM inscricao, voluntario, projeto
          WHERE inscricao.projeto_id = projeto.projeto_id
          AND voluntario.voluntario_id<>6
          AND inscricao.projeto_id = '".$projeto_id."'
          AND inscricao.voluntario_id = voluntario.voluntario_id";

  if (!empty($pais)){
    $query.= " AND voluntario.nacionalidade='".$pais."'";
  }

  if (!empty($nome)){
    $query.= " AND voluntario.nome='".$nome."'";
  }

  $result = mysqli_query($conn, $query);

  return $result;
}


function get_all_projects_filter($spot_yn, $pais, $data){ //pagina list projects
  global $conn;

  $query ="SELECT projeto.projeto_id, projeto.nome_projeto, projeto.max_participantes, projeto.data_inicio, projeto.data_fim, projeto.descricao, projeto.foto, cidade.nome_cidade, cidade.pais, cidade.link_gmaps, COUNT(inscricao.projeto_id) AS \"ocupadas\"
          FROM projeto
          LEFT JOIN inscricao ON projeto.projeto_id = inscricao.projeto_id
          LEFT JOIN cidade ON projeto.cidade_id=cidade.cidade_id
          GROUP BY projeto.projeto_id, cidade.cidade_id
          HAVING data_inicio>='" .$data."'";

  if ($spot_yn){
    $query.= " AND COUNT(inscricao.projeto_id) < projeto.max_participantes";
  }

  if (!empty($pais)){
    $query.= " AND cidade.pais='".$pais."'";
  }

  $query.= " ORDER BY data_inicio";

  $result = mysqli_query($conn, $query);

  return $result;
}


function get_project_by_id($projeto_id){ //página info do projeto
  global $conn;

  $query="SELECT projeto.projeto_id, projeto.nome_projeto, projeto.max_participantes, projeto.data_inicio, projeto.data_fim, projeto.descricao, projeto.foto, projeto.requirements, projeto.highlight1, projeto.highlight2, projeto.highlight3, cidade.nome_cidade, cidade.pais, cidade.link_gmaps,cidade.refeicao,cidade.quarto, cidade.cidade_id, cidade.foto1, cidade.foto2, cidade.foto3, COUNT(inscricao.projeto_id) AS \"ocupadas\"
          FROM projeto
          LEFT JOIN inscricao ON projeto.projeto_id = inscricao.projeto_id
          LEFT JOIN cidade ON projeto.cidade_id=cidade.cidade_id
          GROUP BY projeto.projeto_id, cidade.cidade_id
          HAVING projeto.projeto_id='" .$projeto_id. "'
          ORDER BY projeto.data_inicio DESC";

  $result = mysqli_query($conn, $query);

  return $result;
}

function create_project($nome_projeto, $cidade_id, $data_inicio, $data_fim,  $max_participantes, $descricao,  $requirements, $highlight1, $highlight2,  $highlight3,  $foto){
  global $conn;

  $query = "INSERT INTO projeto
            (nome_projeto, cidade_id, data_inicio, data_fim, max_participantes, descricao, requirements, highlight1, highlight2, highlight3, foto)
            VALUES ('".$nome_projeto."' , '" .$cidade_id. "', '" .$data_inicio."', '".$data_fim."', '" .$max_participantes."', '" .$descricao."', '" .$requirements."','".$highlight1."','".$highlight2."', '".$highlight3."','".$foto."')";

    $result = mysqli_query($conn, $query);
}

 ?>
