<!DOCTYPE html>
<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/project.php";

if(!isset($_SESSION["id"]) || ($_SESSION["id"]<>6)){
  header("Location: ../Common/form_login.php");
}

$pesquisou=0;

$pais         = "";
$nome_projeto = "";


if(isset($_GET["filter"])){
  if(isset($_GET["pais"])){
    $pais = $_GET["pais"];
  }

  if(isset($_GET["nome_projeto"])){
    $nome_projeto = $_GET['nome_projeto'];
  }
  $pesquisou = 1;
}

if(isset($_GET["clean"])){
  $pais         = "";
  $nome_projeto = "";
}

?>

<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../CSS/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../../CSS/private_pages.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Project Method Selection</title>
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
        <!-- Navigation Bar do Gerente-->
        <?php
          include "../../Includes/nav_manager.php";
        ?>

      </div>

        <!-- Zona branca à direita-->
        <div class="rightside">
          <h1> Choose a method to create a new project </h1>
          <br />
          <br />
          <img class="numeros" src ="../../Images/Icons/one.png" alt="Pin">
          <!-- Encaminha para a pagina de criacao do projeto com campos vazios-->
          <a class="verde_grande_link" href="form_create_project.php" >Create from scratch</a>

          <br />
          <br />
          <br />
          <img class="numeros" src ="../../Images/Icons/two.png" alt="Pin">
          <p class="verde_grande_texto">Use an existing project as baseline:</a>

            <br />
            <br />
            <br />
            <!-- Os campos aparecem preenchidos e editaveis, com a informacao do projeto selecionado como baseline-->
            <form action="select_project_create_method.php" method="get">
              <label style="margin-left:70px;"> Country: </label>
              <select name = "pais" class="branco">
                  <option value="0" >Select a country:</option>
                  <option value="Indonesia" <?php if (isset($pais) && $pais=='Indonesia')     echo "selected";?>>Indonesia</option>
                  <option value="Madagascar" <?php if (isset($pais) && $pais=='Madagascar')   echo "selected";?> >Madagascar</option>
                  <option value="Sri Lanka" <?php if (isset($pais) && $pais=='Sri Lanka')     echo "selected";?>>Sri Lanka</option>
              </select>
              <label > Project Name: </label>
              <input type="text" class="branco" name="nome_projeto" value="<?php echo $nome_projeto;?>" />
              <br />
              <input type="submit" value="Filter" name="filter" class="fino" style="margin-left:70px;"/>
              <?php if($pesquisou==1) echo "<input type=\"submit\" value=\"Reset filter\" name=\"clean\" class=\"fino\"/>"; ?>
            </form>

            <br />
            <br />
            <br />

            <table>
              <tr>
                <th>Project</th>
                <th>Location</th>
                <th>Dates</th>
                <th></th>
              </tr>

              <?php
              $result =  get_all_projects_manager2($pais,$nome_projeto);
              $row    = mysqli_fetch_assoc($result);

              while(isset($row['projeto_id']))
              {
                echo"<tr>";
                echo "<td>" . $row["nome_projeto"] . "</td>";
                echo "<td>" . $row["nome_cidade"]. ", ".$row["pais"] . "</td>";
                $data= date("jS M", strtotime($row["data_inicio"]))." till ". date("jS M Y", strtotime($row["data_fim"]));
                echo "<td>" . $data. "</td>";
                echo "<td> <a href='form_create_project.php?id_base=".$row["projeto_id"]."'> Use as Baseline</td>";

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
  <script type="text/javascript" src="../../Javascript/javascript.js"> </script>
</body>
</html>
