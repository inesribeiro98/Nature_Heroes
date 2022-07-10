
<!DOCTYPE html>
<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/project.php";

  $pais      = "";
  $data      = date('Y-m-d');
  $spot_yn   = FALSE;
  $pesquisou = "";

  if(isset($_GET["filter"])){
    if(isset($_GET["pais"])){
      $pais = $_GET["pais"];
    }

    if(isset($_GET["data"])){
      $data = $_GET['data'];
    }
    else {
      $data = date('Y-m-d');
    }

    if(isset($_GET["spot_yn"])){
      $spot_yn = $_GET['spot_yn'];
    }
    else {
      $spot_yn = FALSE;
    }
    $pesquisou = 1;
  }


  if(isset($_GET["clean"])){
    $pais   = "";
    $data   = date('Y-m-d');
    $spot_yn= FALSE;
  }

?>

<html>

  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css"  href="../../CSS/stylesheet.css">
    <link rel="stylesheet" type="text/css"  href="../../CSS/page_list_projects.css">
    <meta name="viewport"  content="width=device-width, initial-scale=1">
    <title>Projects</title>
    <link rel="icon"       type="image/png" href="../../Images/Logo.png"/>
  </head>

  <body>
    <div class="caixa">
      <!-- header -->
      <?php
        include "../../Includes/header.php";
      ?>

      <!-- Imagem c/quadrado  -->
      <div class="container">
          <img class="head" src="../../Images/Backgrounds/background_projects.jpg" alt="Turtle">
          <div class="centered">
            <h3> Open Projects </h3>
          </div>
      </div>

      <!--Zona de pesquisa (verde) -->
      <div class="zona_verde">
        <h5>I'm looking for...</h5>
        <br />
        <form action="list_projects.php" method="get">
          <label> Country: </label>

          <select name = "pais">
              <option value="0" >Select a country:</option>
              <option value="Indonesia" <?php   if (isset($pais) && $pais=='Indonesia')     echo "selected";?>>Indonesia</option>
              <option value="Madagascar" <?php  if (isset($pais) && $pais=='Madagascar')    echo "selected";?> >Madagascar</option>
              <option value="Sri Lanka" <?php   if (isset($pais) && $pais=='Sri Lanka')     echo "selected";?>>Sri Lanka</option>
          </select>

          <label > Date after: </label>
          <input type="date"     name="data"    value="<?php echo $data;?>"   min="<?php echo date('Y-m-d');?>"/>
          <input type="checkbox" name="spot_yn" id="spot" <?php if ($spot_yn) echo "checked";?>/>
          <label for="spot" > Show only projects with open spots </label>
          <br />
          <input type="submit"   value="Filter" name="filter"/>
          <?php if($pesquisou==1) echo "<input type=\"submit\" value=\"Reset filter\" name=\"clean\"/>"; ?>
        </form>
      </div>

      <div class="whitepart">

      <?php
        $result = get_all_projects_filter($spot_yn, $pais, $data);
        $row    = pg_fetch_assoc($result);

        if (!isset($row["projeto_id"])){
          echo "<p class=\"aviso\"> Unfortunately, we have no projects for the filters you selected! </p>";
        }
        else {

          /* Inserir projetos na pagina */
          while(isset($row["projeto_id"])){
          ?>
              <div class= "row">

                <!--Imagem à esquerda -->
                <div class= "columnleft">
                  <img class="esquerda" src="../../Images/Project_images/<?php if (!empty($row["foto"])) echo $row["foto"]; else echo 'logo.png';?>" alt="Project Photo">
                </div>
                <div class= "columnleft2" >
                  <h2><?php echo $row["nome_projeto"];?></h2>

                  <?php
                    $data = date("jS F Y", strtotime($row["data_inicio"]));
                    $data = $data. " to " .date("jS F Y", strtotime($row["data_fim"]));
                  ?>

                  <p style="color:rgb(56, 87, 35);"> <img class="smallicon" src="../../Images/Icons/event.png" alt="Duration">  <b> Dates: </b> <span style="color:black;"><?php echo $data;?></span></p>
                  <p style="color:rgb(56, 87, 35);"> <img class="smallicon" src="../../Images/Icons/pin.png" alt="Pin" > <b> Location:  </b> <a class="link" href ="<?php echo $row["link_gmaps"];?>" target="_blank"><?php echo $row["nome_cidade"]. ", " .$row["pais"];?> </a> </p>
                  <p style="color:rgb(56, 87, 35);"> <img class="smallicon" src="../../Images/Icons/info.png" alt="Info" >  <b> Description:  </b> <span style="color:black;"> <?php echo $row["descricao"];?> </span></p>

                  <?php //mensagem se já so houver 5 ou menos spots
                  $nr_vagas = $row["max_participantes"] - $row["ocupadas"];

                  if ($nr_vagas==0) {
                    echo "<p class=\"vagas\"> No more spots left!</p>";
                  }
                  elseif ($nr_vagas<=5 && $nr_vagas>0) {
                    echo "<p class=\"vagas\"> Only ".$nr_vagas." spots left!</p>";
                  }
                  ?>
                  <a href="project_info.php?id=<?php echo $row["projeto_id"];?>" class="projetos" > <span>  More info  </span> </a>
                </div>
              </div>

              <?php
              $row = pg_fetch_assoc($result);

              /*Imagem à direita */
              if (isset($row["projeto_id"])){ /*verifica se existe valor */
              ?>
                <hr>

                  <div class= "row">
                    <div class= "columnright">
                      <h2><?php echo $row["nome_projeto"];?></h2>
                      <?php
                        $data = date("jS F Y", strtotime($row["data_inicio"]));
                        $data = $data. " to " .date("jS F Y", strtotime($row["data_fim"]));
                      ?>
                      <p style="color:rgb(56, 87, 35);"> <img class="smallicon" src="../../Images/Icons/event.png" alt="Duration">  <b> Dates: </b> <span style="color:black;"><?php echo $data;?></span></p>
                      <p style="color:rgb(56, 87, 35);"> <img class="smallicon" src="../../Images/Icons/pin.png" alt="Pin" > <b> Location:  </b> <a class="link" href ="<?php echo $row["link_gmaps"];?>" target="_blank"><?php echo $row["nome_cidade"]. ", " .$row["pais"];?></a> </p>
                      <p style="color:rgb(56, 87, 35);"> <img class="smallicon" src="../../Images/Icons/info.png" alt="Info" >  <b> Description:  </b> <span style="color:black;"> <?php echo $row["descricao"];?> </span></p>
                      <?php
                      $nr_vagas = $row["max_participantes"] - $row["ocupadas"];

                      if ($nr_vagas==0) {
                        echo "<p class=\"vagas\"> No more spots left!</p>";
                      }
                      elseif ($nr_vagas<=5 && $nr_vagas>0) {
                        echo "<p class=\"vagas\"> Only ".$nr_vagas." spots left!</p>";
                      }
                      ?>
                      <a href="project_info.php?id=<?php echo $row["projeto_id"];?>" class="projetos" > <span>  More info  </span> </a>
                    </div>
                    <div class= "columnright2" >
                      <img class="direita" src="../../Images/Project_images/<?php if (!empty($row["foto"])) echo $row["foto"]; else echo 'logo.png';?>" alt="Project Photo">
                    </div>
                  </div>

              <?php
              }

              $row = pg_fetch_assoc($result);

              if (isset($row["projeto_id"])){ /*só adiciona linha se houver um valor a seguir*/
                echo "<hr />";
              }
          }
        }
        ?>

      </div>

      <!-- Footer -->
      <?php
        include "../../Includes/footer.php";
      ?>
    </div>
  </body>
</html>
