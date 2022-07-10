<!DOCTYPE html>
<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/volunteer.php";

  if(!isset($_SESSION["id"]) || ($_SESSION["id"]<>6)){
    header("Location: ../Common/form_login.php");
  }

  $pesquisou = 0;

  if(isset($_GET["filter"])){
    $pesquisou = 1;
    if(isset($_GET["pais"])){
      $pais    = $_GET["pais"];
    }

    if(isset($_GET["projects_yn"])){
      $projects_yn = $_GET['projects_yn'];
    }
    else {
      $projects_yn = "";
    }

    if(isset($_GET["nome"])){
      $nome = $_GET["nome"];
    }

  }
  else {
      $pais        = "";
      $nome        = "";
      $projects_yn = "";
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
            <h1> List all volunteers </h1>
            <!-- Form para filtrar-->
            <form action="list_volunteers.php" method="get">
              <label> Country: </label>
              <select class="branco" name = "pais">
                  <option value="0" >Select a country:</option>
                  <?php
                  $result = get_all_countries();
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

              <input type="checkbox" name="projects_yn" id="spot" <?php if ($projects_yn)  echo "checked";?>/>
              <label for="spot" > Only enrolled in projects </label>
              <br>
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
              <th>Enrolled Projects</th>
              </tr>

              <?php
              //Display na tabela dos voluntarios que satisfazem os criterios do filtro
              $result =get_all_volunteers($pais, $nome, $projects_yn);
              $row    = mysqli_fetch_assoc($result);

              while(isset($row['voluntario_id']))
              {
                echo"<tr>";
                echo "<td>" . $row["nome"] . "</td>";
                echo "<td>" . $row["nacionalidade"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["telemovel"] . "</td>";
                echo "<td>";

                //Mostrar para cada voluntario em que projetos e que ele esta inscrito
                $result2 = get_enrolled_projects($row['voluntario_id']);
                $row2    = mysqli_fetch_assoc($result2);

                if (!isset($row2["projeto_id"])){
                  echo "None";
                }
                else {
                    while(isset($row2["projeto_id"])){
                      echo $row2["nome_projeto"];
                    $row2    = mysqli_fetch_assoc($result2);
                      if(isset($row2["projeto_id"])){
                        echo "<br />";
                      }
                    }
                  }
                  echo "</td>";
                  $row    = mysqli_fetch_assoc($result);
                }
             ?>

            </table>
            </div>



        <!-- Footer -->
        <?php
          include "../../Includes/footer.php";
        ?>
        </div>
        </div>
  </body>
</html>
