<!DOCTYPE html>
<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/project.php";

  $pesquisou=0;

  if(!isset($_SESSION["id"]) || ($_SESSION["id"]<>6)){
    header("Location: ../Common/form_login.php");
  }

  $pais         = "";
  $spot_yn      = FALSE;
  $nome_projeto = "";
  $url          = "";
  $sort         = " ORDER BY projeto.nome_projeto"; //texto para sorting
  $tipo         ="nome_projeto";  //variavel para sorting (inicialmente é pelo nome do projeto)
  $dir          = "asc"; //direção do sorting

  if(isset($_GET["filter"])){
    if(isset($_GET["pais"])){ //filtrar por pais
      $pais = $_GET["pais"];
      $url .="&pais=".$pais;
    }

    if(isset($_GET["spot_yn"])){ //filtrar so projetos com vagas
      $spot_yn = $_GET['spot_yn'];
      $url    .="&spot_yn=".$spot_yn;
    }
    else {
      $spot_yn = FALSE;
    }

    if(isset($_GET["nome_projeto"])){ //filtrar pelo nome do projeto
      $nome_projeto = $_GET["nome_projeto"];
      $url         .="&nome_projeto=".$nome_projeto;
    }

    $url      .="&filter=Filter";
    $pesquisou = 1;
  }

//SORTING
  if (isset($_GET['sort']) && ($_GET['sort'] == 'nome_projeto')){ //Foi feito sorting pelo nome do projeto
    $sort = "ORDER BY projeto.nome_projeto";
    $tipo = $_GET['sort'];
  }
  elseif (isset($_GET['sort']) && ($_GET['sort'] == 'cidade')){
    $sort = "ORDER BY cidade.nome_cidade";
    $tipo = $_GET['sort'];
  }
  elseif (isset($_GET['sort']) && ($_GET['sort'] == 'data')){
    $sort = "ORDER BY projeto.data_inicio";
    $tipo = $_GET['sort'];
  }

  if(isset($_GET['dir']) && ($_GET['dir'] == 'asc')){ //foi feita sorting ascendente
    $sort .= " ASC";
    $dir = $_GET['dir'];
  }
  elseif (isset($_GET['dir']) && ($_GET['dir'] == 'desc')){
    $sort .= " DESC";
    $dir = $_GET['dir'];
  }
  ?>

  <html>

  <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" type="text/css" href="../../CSS/stylesheet.css">
      <link rel="stylesheet" type="text/css" href="../../CSS/private_pages.css">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>List Projects</title>
      <link rel="icon" type="image/png" href="../../Images/Logo.png"/>
  </head>

  <body>
      <div class="caixa">

        <!-- Navigation Bar -->
        <?php
          include "../../Includes/header.php";
        ?>

        <div class="bigbox">
          <!-- Zona verde à esquerda-->
          <div class="sidenav">
             <!-- Navigation Bar do Gerente -->
            <?php
              include "../../Includes/nav_manager.php";
             ?>
          </div>

            <!-- Zona branca à direita-->
          <div class="rightside">
            <h1> Projects List </h1>

            <form action="list_projects_manager.php?sort=<?php echo $tipo;?>&dir=<?php echo $dir;?>" method="get">
              <label> Country: </label>
              <select class="branco" name = "pais">
                  <option value="0" >Select a country:</option>
                  <option value="Indonesia" <?php if (isset($pais) && $pais=='Indonesia')     echo "selected";?>>Indonesia</option>
                  <option value="Madagascar" <?php if (isset($pais) && $pais=='Madagascar')   echo "selected";?> >Madagascar</option>
                  <option value="Sri Lanka" <?php if (isset($pais) && $pais=='Sri Lanka')     echo "selected";?>>Sri Lanka</option>
              </select>

              <label > Project Name: </label>
              <input class="branco"  type="text" name="nome_projeto" value="<?php echo $nome_projeto;?>">

              <input type="checkbox" name="spot_yn" id="spot" <?php if ($spot_yn)  echo "checked";?>/>
              <label for="spot" > Open spots only </label>
              <br>
              <input type="submit" value="Filter" name="filter" class="fino"/>
              <?php if($pesquisou==1) echo "<input type=\"submit\" value=\"Reset filter\" name=\"clean\" class=\"fino\"/>"; ?>
            </form>

            <br />
            <br />
            <br />

            <table>
              <tr>
              <th><a href="list_projects_manager.php?sort=nome_projeto&dir=<?php
              if (($tipo == "nome_projeto") && ($dir == "asc")){
                echo "desc";
              }
              else {
                echo "asc";
              }
                echo $url;?>">Project <?php if ($tipo <> "nome_projeto"){
                echo "<span style='color:lightgrey;'> &#9660;</span>";
              }
              else {
                if ($dir == "asc"){
                  echo "&#9660;";
                }
                else {
                  echo "&#9650;";
                }
              }?> </a></th>
              <th><a href="list_projects_manager.php?sort=cidade&dir=<?php
              if (($tipo == "cidade") && ($dir == "asc")){
                echo "desc";
              }
              else {
                echo "asc";
              }
              echo $url;?>">Location <?php if ($tipo <> "cidade"){
                echo "<span style='color:lightgrey;'> &#9660;</span>";
              }
              else {
                if ($dir == "asc"){
                  echo "&#9660;";
                }
                else {
                  echo "&#9650;";
                }
              }?> </a></th>

              <th><a href="list_projects_manager.php?sort=data&dir=<?php
              if (($tipo == "data") && ($dir == "asc")){
                echo "desc";
              }
              else {
                echo "asc";
              }
              echo $url;?>">Start Date <?php if ($tipo <> "data"){
              echo "<span style='color:lightgrey;'> &#9660;</span>";
              }
              else {
                if ($dir == "asc"){
                  echo "&#9660;";
                }
                else {
                  echo "&#9650;";
                }
              }?> </a></th>

              <th>Filled Spots</th>
              <th> </th>
              </tr>

              <?php
              //Display na tabela dos projetos que satisfazem as condicoes
              $result =get_all_projects_manager($spot_yn, $pais,$nome_projeto,$sort);

              $row    = mysqli_fetch_assoc($result);

              while(isset($row['projeto_id']))
              {
                $data = date("d/m/Y", strtotime($row["data_inicio"]));
                echo"<tr>";
                echo "<td>" . $row["nome_projeto"] . "</td>";
                echo "<td>" . $row["nome_cidade"]  . "</td>";
                echo "<td>" . $data                . "</td>";
                echo "<td>" . $row["ocupadas"] . "/" . $row["max_participantes"] . "</td>";

                if ($row["ocupadas"]==0) { //se nao houver inscricoes no projeto ele nao da a opcao de ver os applicants
                  echo "<td> <a href='form_edit_project.php?id_proj=".$row["projeto_id"]."'> More info/Edit </a> </td>";
                }
                else {
                  echo "<td> <a href='list_volunteers_in_project.php?id_proj=".$row["projeto_id"]."'> View Applicants </a> <br> <a href='form_edit_project.php?id_proj=".$row["projeto_id"]."'> More info/Edit </a> </td>";
                }

                $row    = mysqli_fetch_assoc($result);
              }

             ?>

            </table>
            </div>
          </div>


        <!-- Footer -->
        <?php
          include "../../Includes/footer.php";
        ?>

        </div>
  </body>
</html>
