<!DOCTYPE html>
<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/project.php";
  include "../../Database/volunteer.php";

  if(!isset($_SESSION["id"]) || ($_SESSION["id"]<>6)){
    header("Location: ../Common/form_login.php");
  }

  if(isset($_GET['id_proj'])){
    $projeto_id = $_GET['id_proj'];
  }

  $pesquisou = 0;

  if(isset($_GET["filter"])){
    $pesquisou = 1;
    if(isset($_GET["pais"])){
      $pais = $_GET["pais"];
    }

    if(isset($_GET["nome"])){
      $nome = $_GET["nome"];
    }

  }
  else {
      $pais = "";
      $nome = "";
  }
  ?>

  <html>

  <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" type="text/css" href="../../CSS/stylesheet.css">
      <link rel="stylesheet" type="text/css" href="../../CSS/private_pages.css">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>List Volunteers</title>
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

            <?php
            $result =  get_project_by_id($projeto_id);
            $row    = mysqli_fetch_assoc($result);
             ?>
            <h1> Volunteers enrolled in project:<br><?php echo $row['nome_projeto'] ?></h1>
            <br>
            <!-- Form filtro-->
            <form action="list_volunteers_in_project.php" method="get">
              <label> Country: </label>
              <select class="branco" name = "pais">
                  <option value="0" >Select a country:</option>
                  <?php
                  $result= get_all_countries();
                  $row    = mysqli_fetch_assoc($result);

                  while (isset($row["nacionalidade"])){?>
                    <option value="<?php echo $row['nacionalidade'];?>"<?php if ($pais==$row['nacionalidade']) echo "selected";?>><?php echo $row['nacionalidade'];?></option>

                  <?php
                    $row    = mysqli_fetch_assoc($result);
                  }
                    ?>
              </select>

              <label > Name: </label>
              <input class="branco"  type="text" name="nome" value="<?php echo $nome;?>">
              <br>

              <input type="hidden" name="id_proj" value="<?php echo $projeto_id;?>">
              <input type="submit" value="Filter" name="filter" class="fino"/>
              <?php if($pesquisou==1) echo "<input type=\"submit\" value=\"Reset filter\" name=\"clean\" class=\"fino\"/>"; ?>

            </form>

            <br />
            <br />
            <br />

            <table>
              <tr>
              <th>Name</th>
              <th>Country</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th> </th>
              </tr>

              <?php
              //Display na tabela dos voluntarios que estao inscritos naquele projeto
              $result =  get_volunteers_project($projeto_id, $pais, $nome);
              $row    = mysqli_fetch_assoc($result);

              while(isset($row['voluntario_id']))
              {
                echo "<tr>";
                echo "<td>" . $row["nome"]          . "</td>";
                echo "<td>" . $row["nacionalidade"] . "</td>";
                echo "<td>" . $row["email"]         . "</td>";
                echo "<td>" . $row["telemovel"]     . "</td>";
                echo "<td> <a href= '../Volunteer/form_apply_to_project.php?id_proj=".$projeto_id."&id_vol=".$row['voluntario_id']."'> View application </a>";
                echo "</td>";

                $row    = mysqli_fetch_assoc($result);
                }
             ?>

            </table>
            <br>
            <a href="list_projects_manager.php" class="button_back"><h4>Back</h4></a>

            </div>

        <!-- Footer -->
        <?php
          include "../../Includes/footer.php";
        ?>
        </div>
        </div>
  </body>
</html>
