<!DOCTYPE html>
<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/project.php";
  include "../../Database/application.php";

  if(!isset($_SESSION["id"])){
    header("Location: ../Common/form_login.php");
  }

  $motivation       = "";
  $medical_history  = "";
  $diet             = "";
  $comment          = "";
  $read             = false;
  $privacy          = false;

  if(isset($_GET["id"])){ //está a inscrever-se
    $projeto_id = $_GET["id"];
    $block      = false;
  }
  elseif (isset($_GET['id_proj'])){ //está a ser consultado atraves da pagina list_volunteers_in_project do gerente
    $projeto_id    = $_GET['id_proj'];
    $voluntario_id = $_GET['id_vol'];
    $block         = true;
    $origem        = "../../Pages/Manager/list_volunteers_in_project.php?id_proj=$projeto_id";

    $result = get_application($voluntario_id, $projeto_id);
    $row    = pg_fetch_assoc($result);

    $medical_history = $row["medical_history"];
    $motivation      = $row["motivacao"];
    $diet            = $row["dieta"];
    $comment         = $row["comentario"];

  }
  elseif(isset($_GET["info_id"])) { // o voluntario está a consultar a sua inscrição
    $projeto_id      = $_GET["info_id"];
    $block           = true;
    $origem          = "../../Pages/Volunteer/volunteer_main_page.php";

    $result = get_application($_SESSION["id"], $projeto_id);
    $row    = pg_fetch_assoc($result);

    $medical_history = $row["medical_history"];
    $motivation      = $row["motivacao"];
    $diet            = $row["dieta"];
    $comment         = $row["comentario"];

  }
  else { //não há ID
    header("Location: ../Common/list_projects.php");
  }

  $_SESSION["origem_projeto"] = $projeto_id;

  $result = get_project_by_id($projeto_id);
  $row    = pg_fetch_assoc($result);

  $nome_projeto     = $row["nome_projeto"];
  $data_inicio      = $row["data_inicio"];
  $data_fim         = $row["data_fim"];
  $foto             = $row["foto"];
  $cidade           = $row["nome_cidade"];
  $pais             = $row["pais"];


  $error_motivation = false;
  if (!empty($_SESSION['msg_erro'] )) {  /*recuperação de valores, se for o caso*/
        if (!empty($_SESSION['medical_history'])){
            $medical_history = $_SESSION['medical_history'];
        }

        if (!empty($_SESSION['motivation'])){
            $motivation       = $_SESSION['motivation'];
        }
        else{
            $error_motivation = true;
        }

        if (!empty($_SESSION['diet'])){
          $diet  = $_SESSION['diet'];
        }

        if (!empty($_SESSION['comment'])){
          $comment = $_SESSION['comment'];
        }

        if (($_SESSION['read'])){
          $read = true;
        }

        if (($_SESSION['privacy'])){
          $privacy = true;
        }

        $_SESSION['motivation']       = NULL;
        $_SESSION['medical_history']  = NULL;
        $_SESSION['diet']             = NULL;
        $_SESSION['comment']          = NULL;
    }
?>

<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../CSS/stylesheet.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if($block){
      echo "Application from ".$_SESSION["nome"]." to project ".$nome_projeto;
    }
    else{
      echo "Apply to: ".$nome_projeto;
    }
      ?>
    </title>
    <link rel="icon" type="image/png" href="../../Images/Logo.png"/>

  </head>

  <body>
    <div class="caixa">
      <!-- header -->
      <?php
        include "../../Includes/header.php";
      ?>

        <div class="whitepart">

            <h2> <?php if($block){
                  echo "Application to project: " .$nome_projeto;
                }
                else {
                  echo "You are about to apply to project: " .$nome_projeto;
                } ?>
            </h2>


            <div id="apply_texto">
              <!--mensagem de erro-->
              <?php
              if (!empty($_SESSION['msg_erro'] )) {
                echo "<p class ='aviso'> ".$_SESSION['msg_erro']."<p>";
                $_SESSION['msg_erro'] = NULL;
              }
              ?>

              <div id="apply_esq">


                <form action="../../Actions/Volunteer/action_apply.php" method="post">
                  <label class="label_apply"> Relevant medical history: </label>
                  <textarea type="apply" name ="medical_history" <?php if ($block) echo "disabled";?>><?php echo $medical_history;?></textarea>

                  <label class="label_apply"> Share with us your motivation to apply! </label>
                  <textarea type="apply" style="height:150px;" name ="motivation" style="<?php if ($error_motivation){ echo 'border: 1.5px solid red;';} ?>" <?php if ($block) echo "disabled";?> ><?php echo $motivation;?></textarea>

                  <label class="label_apply"> Dietary restrictions: </label>
                  <input type="text"  name ="diet"  class="text_apply" value="<?php echo $diet;?>" <?php if ($block) echo "disabled";?> />

                  <label class="label_apply"> Any extra comment? </label>
                  <input type="text"  name ="comment"  class="text_apply" value="<?php echo $comment;?>" <?php if ($block) echo "disabled";?>/>
                  <br />
                  <?php
                  if (!$block){

                  ?>
                  <input type="checkbox" name="read" id="read1"  class="read_check" <?php if ($read) echo "checked";?>/>
                  <label for="read1" class="read_label">I have read and I’m aware of the requirements for this project, and I hold full responsibility for fulling them.</label>
                  <br />
                  <input type="checkbox" name="privacy" id="privacy1" class="read_check" <?php if ($privacy) echo "checked";?> />
                  <label for="privacy1" class="read_label" >I agree to the Nature Heroes Terms and Conditions of Service and Privacy Policy.</label>

                  <br />
                  <input type ="hidden" name ="projeto_id"     value="<?php echo $projeto_id; ?>" />
                  <input type ="hidden" name ="voluntario_id"  value="<?php echo $_SESSION["id"]; ?>" />

                  <input type ="submit" class="apply" value="Submit!" name="inscrever" />
                  <input type ="submit" class="apply" value="Cancel"  name="cancelar"/>
                  <?php
                } elseif ($block){
                  ?>
                    <a href="<?php echo $origem;?>" class="button_back"><h4>Back</h4></a>

                    <?php
                }
                  ?>
                </form>
              </div>

              <div id="apply_dir">
                <img class="img_apply" src="../../Images/Project_images/<?php echo $foto;?>" alt="Project Photo">
                <h6><?php echo date("jS M", strtotime($data_inicio));?> till <?php echo date("jS M Y", strtotime($data_fim));?></h6>
                <h6><?php echo $cidade;?>, <?php echo $pais;?> </h6>
              </div>
            </div>


        </div>
        <!-- Footer -->
        <?php
          include "../../Includes/footer.php";
        ?>
    </div>


</body>

</html>
