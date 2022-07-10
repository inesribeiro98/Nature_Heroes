<!DOCTYPE html>
<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/project.php";
  include "../../Database/application.php";
  include "../../Database/feedback.php";

  if(isset($_GET["id"])){
    $projeto_id=$_GET["id"];
  }
  else {
    header("Location: ../../Pages/Common/index.php");
  }

    $result = get_project_by_id($projeto_id);
    $row    = pg_fetch_assoc($result);

    $nome_projeto     = $row["nome_projeto"];
    $max_participantes= $row["max_participantes"];
    $data_inicio      = $row["data_inicio"];
    $data_fim         = $row["data_fim"];
    $descricao        = $row["descricao"];
    $requirements     = $row["requirements"];
    $highlight1       = $row["highlight1"];
    $highlight2       = $row["highlight2"];
    $highlight3       = $row["highlight3"];
    $ocupadas         = $row["ocupadas"];
    $foto             = $row["foto"];
    $cidade           = $row["nome_cidade"];
    $pais             = $row["pais"];
    $maps             = $row["link_gmaps"];
    $refeicao         = $row["refeicao"];
    $quarto           = $row["quarto"];
    $cidade_id        = $row["cidade_id"];
    $foto_cidade1     = $row["foto1"];
    $foto_cidade2     = $row["foto2"];
    $foto_cidade3     = $row["foto3"];

    if ($ocupadas == $max_participantes){
      $livre = false;
    }
    else {
      $livre = true;
    }


  $ja_inscreveu = false;
  //Testar se o voluntário que está autenticado ja esta inscrito neste projeto//
  if (isset($_SESSION["id"]) ){
    $num_registos = volunteer_in_project($_SESSION["id"], $projeto_id);

    if ($num_registos>0){
      $ja_inscreveu = true;
    }
  }

?>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../CSS/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../../CSS/page_more_info.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <meta name="viewport"  content="width=device-width, initial-scale=1">
    <title><?php echo $nome_projeto;?></title>
    <link rel="icon" type="image/png" href="../../Images/Logo.png"/>
  </head>

  <body onload="abrir_more_info()">
    <div class="caixa">
        <!-- header -->
        <?php
          include "../../Includes/header.php";
        ?>

        <!-- Imagem c/quadrado  -->
        <div class="container">
         <img class="head" src="../../Images/Backgrounds/background-project_info.jpg" alt="Project" >
         <div class="centered"> <h3> <?php echo $nome_projeto;?> </h3> </div>
        </div>

        <div class="whitepart">

          <!--Zona fixa à direita  -->
          <div class=" containerright">

            <button id="apply" onclick="window.location.href = '../Volunteer/form_apply_to_project.php?id=<?php echo $row["projeto_id"];?>';" <?php if(($_SESSION["id"]==6) ||$ja_inscreveu || !$livre || ($data_inicio <= date('Y-m-d'))) echo "disabled";?>> <span> <h4>
              <?php //texto do otão varia com a situação
              if ($livre && ($data_inicio <= date('Y-m-d'))){
                echo "Applications closed";
              }
              elseif ($ja_inscreveu){
                echo "You have already applied to this project";
              }
              elseif(!$livre){
                echo "No more spots left";
              }
              elseif ($livre && ($data_inicio > date('Y-m-d'))) {
                echo "Apply here!";
              }
              ?> </h4></span></button>

            <div class="highlights"> <!-- highlights e info-->
              <?php if (!empty($highlight1)){ ?>
                <h2 style="font-size: 22px;"> Project Highlights </h2>
                <ul class="high">
                  <li class="high"> <p><?php echo $highlight1;?></p> </li>
                  <?php if(!empty($highlight2)){ echo "<li class=\"high\"> <p>".$highlight2."</p></li>";}?>
                  <?php if(!empty($highlight3)){ echo "<li class=\"high\"> <p>".$highlight3."</p></li>";}?>
                </ul>
              <?php } ?>

              <div class="flex-container2">
                <div class="container"> <img src ="../../Images/Icons/pin.png" alt="Pin" style="width:50px;height:50px">
                 <p class="centra"> <a class="link" href ="<?php echo $maps; ?>" target="_blank"><?php echo $cidade. ', '.$pais;?></a> </p>
                </div>

               <div class="container"> <img src ="../../Images/Icons/clock.png" alt="Clock" style="width:50px;height:50px">
                <p class="centra"><?php echo date("jS M", strtotime($row["data_inicio"]));?> till <?php echo date("jS M Y", strtotime($row["data_fim"]));?></p>
               </div>
              </div>
            </div>
          </div>

          <!--Zona da esquerda  -->
          <div class="area">
            <h2 > Description </h2>
            <p > <?php echo $descricao;?> </p>
            <br />
            <br />
            <h2 >See the city! </h2>
            <br />

            <div class="slideshow-container"> <!-- slideshow -->

            <div class="mySlides fade">
              <img class="slide" src="../../Images/City_images/<?php echo $foto_cidade1;?>" style="width:100%">
            </div>

            <div class="mySlides fade">
              <img class="slide" src="../../Images/City_images/<?php echo $foto_cidade2;?>" style="width:100%">
            </div>

            <div class="mySlides fade">
              <img class="slide" src="../../Images/City_images/<?php echo $foto_cidade3;?>" style="width:100%">
            </div>

            <?php
            if (!empty($foto)){
              ?>
              <div class="mySlides fade">
                <img class="slide" src="../../Images/Project_images/<?php echo $foto; ?>" style="width:100%">
              </div>
            <?php
            }
             ?>

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

            </div>
            <br>

            <div style="text-align:center">
              <span class="dot" onclick="currentSlide(1)"></span>
              <span class="dot" onclick="currentSlide(2)"></span>
              <span class="dot" onclick="currentSlide(3)"></span>
              <?php
              if (!empty($foto)){
                ?>
                <span class="dot" onclick="currentSlide(4)"></span>
              <?php
              }
               ?>
            </div>


            <br />
            <br />

            <h2 > Details </h2> <!-- accordion -->

            <button class="accordion" > <img class="smallicon" src="../../Images/Icons/bed.png" alt="Bed">  Accomodation  </button>
            <div class="panel">
              <p> <?php echo $quarto;?></p>
            </div>

            <button class="accordion" > <img class="smallicon" src="../../Images/Icons/food.png" alt="Meals">   Meals </button>
            <div class="panel">
              <p> <?php echo $refeicao;?></p>
            </div>

            <button class="accordion" > <img class="smallicon" src="../../Images/Icons/puzzle.png" alt="Included">  <span> What's included</span>  </button>
            <div class="panel">
              <ul class="high">
                <li class="act"> <p> Online volunteer training and preparation tools </p> </li>
                <li class="act"> <p> Airport transfer </p> </li>
                <li class="act"> <p> 24/7 in-country support</p> </li>
                <li class="act"> <p> All meals and accomodation (as described in the previous sections)</p> </li>
              </ul>
              <p style="color:rgb(56, 87, 35);"> <b> Note: </b></p>
              <p> Flights, vaccinations, travel insurance and VISA (if necessary) <u> not included</u> </p>
            </div>

            <button class="accordion"> <img class="smallicon" src="../../Images/Icons/list.png" alt="Requirements">  <span> Requirements for volunteers </span>  </button>
            <div class="panel">
             <p>Volunteers need to be 18 years or over. </p>
             <p> All volunteers are required to have adequate volunteer travel insurance and provide a criminal background check. </p>
             <p> <?php echo $requirements;?></p>
            </div>

            <br />
            <br />

            <h2 > Check out feedback for our projects in <?php echo $cidade;?></h2> <!-- feedbacks -->
            <?php
              $result = feedback_from_city($cidade_id);
              $row    = pg_fetch_assoc($result);
              while(isset($row["testemunho"])){

                 ?>
                <div class="feedbacks">
                  <div class="feedback_foto">
                    <img class="img_feedback" src="../../Images/Project_images/<?php if (!empty($row["foto"])) echo $row["foto"]; else echo 'logo.png';?>">
                  </div>

                  <div class="feedback_texto">
                    <p class="verde"><?php echo $row["nome"];?>, <?php echo $row["nome_projeto"]?>, <?php echo date("F Y", strtotime($row["data_inicio"]));?></p>
                    <p> <?php echo $row["testemunho"];?> </p>
                  </div>
                </div>
              <?php
                $row  = pg_fetch_assoc($result);
              }
               ?>

          </div>
          <!-- Footer -->
          <?php
            include "../../Includes/footer.php";
          ?>
        </div>
    </div>
</body>
<script type="text/javascript" src="../../Javascript/javascript.js"> </script>
</html>
