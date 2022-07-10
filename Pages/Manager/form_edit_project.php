<!DOCTYPE html>
<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/project.php";
  include "../../Database/city.php";

//Se o login não for o do gerente volta para a pagina de sign in
  if(!isset($_SESSION["id"]) || ($_SESSION["id"]<>6)){
    header("Location: ../Common/form_login.php");
  }

  if(isset($_GET["from_feedback_id"])){
    $projeto_id = $_GET["from_feedback_id"];
    $origem     = "../../Pages/Manager/manage_feedback.php";
  }
  elseif (isset($_GET["id_proj"])) {
    $projeto_id = $_GET["id_proj"];
    $origem     = "../../Pages/Manager/list_projects_manager.php";
  }
  elseif(isset($_GET["edit_id"])){
    $projeto_id = $_GET["edit_id"];
    $origem     = "../../Pages/Manager/list_projects_manager.php";
  }
  else {
    header("Location: ../Manager/list_projects_manager.php");
  }

  $erro=false;

if (!empty($_SESSION['msg_erro'] )) {
        $erro = true;

        if (!empty($_SESSION['max_participantes'])){
          $max_participantes = $_SESSION['max_participantes'];
        }
        else {
          $max_participantes = "";
        }

        if (!empty($_SESSION['descricao'])){
          $descricao         = $_SESSION['descricao'];
        }
        else {
          $descricao         = "";
        }

        if (!empty($_SESSION['requirements'])) 		 	$requirements = $_SESSION['requirements']; 			   		else $requirements = "";
        if (!empty($_SESSION['highlight1'])) 		   	$highlight1 = $_SESSION['highlight1']; 				      	else $highlight1 = "";
        if (!empty($_SESSION['highlight2'])) 		   	$highlight2 = $_SESSION['highlight2']; 				      	else $highlight2 = "";
        if (!empty($_SESSION['highlight3'])) 		   	$highlight3 = $_SESSION['highlight3']; 				      	else $highlight3 = "";


        $_SESSION['max_participantes']= NULL;
        $_SESSION['descricao']        = NULL;

        $_SESSION['highlight1']       = NULL;
        $_SESSION['highlight2']       = NULL;
        $_SESSION['highlight3']       = NULL;

        $result = get_project_by_id($projeto_id);
        $row    = pg_fetch_assoc($result);

        $nome_projeto       = $row["nome_projeto"];
        $cidade_id          = $row["cidade_id"];
        $data_inicio        = $row["data_inicio"];
        $data_fim           = $row["data_fim"];
        $requirements       = $row["requirements"];

    }
    else {
      $result = get_project_by_id($projeto_id);
      $row    = pg_fetch_assoc($result);

      $nome_projeto       = $row["nome_projeto"];
      $cidade_id          = $row["cidade_id"];
      $data_inicio        = $row["data_inicio"];
      $data_fim           = $row["data_fim"];
      $max_participantes  = $row["max_participantes"];
      $descricao          = $row["descricao"];
      $requirements       = $row["requirements"];
      $highlight1         = $row["highlight1"];
      $highlight2         = $row["highlight2"];
      $highlight3         = $row["highlight3"];

    }

?>

<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../CSS/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../../CSS/private_pages.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project info: <?php echo $nome_projeto;?></title>
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
          <h1> Project info: <?php echo $nome_projeto;?> </h1>

          <br />

          <!--mensagem de erro-->
          <?php
          if (!empty($_SESSION['msg_erro'] )) {
            echo "<p class ='aviso'> ".$_SESSION['msg_erro']."<p>";
		        $_SESSION['msg_erro'] = NULL;
          }
          ?>

          <!--form-->
          <form action="../../Actions/Manager/action_edit_project.php" method="post" onsubmit="return editavel_manager()">

            <label class="label_normal"> Description: </label>
            <textarea  class="proj_edit" type="descricao" maxlength="750" name ="descricao" <?php if ($erro){ echo "style='border: 1.5px solid red;'";}else{echo "disabled";} ?> /><?php echo $descricao;?></textarea>

            <br />

            <div class="row">
              <div class="left">
                <label  class="label_normal"> Location: </label>
                <select name = "cidade_id" disabled >
                    <option value="0">Select a city:</option>
                        <?php
                          $result = getAllCities();
                          $row    = pg_fetch_assoc($result);

                          while (isset($row["cidade_id"])){
                            echo "<option value=' " .$row["cidade_id"]. "'";
                            if( $cidade_id == $row['cidade_id']){
                              echo "selected";
                            }
                            echo  ">". $row['nome_cidade']. ", " .$row['pais']."</option>";
                            $row=pg_fetch_assoc($result);
                          }
                          ?>
                </select>
              </div>

              <div class="right">
                <label class="label_numero"> Maximum Number of Spots:</label>
                <input class="proj_edit" type="integer" name ="max_participantes"  <?php if ($erro){ echo "style='border: 1.5px solid red;'";}else{echo "disabled";} ?>  value ="<?php echo $max_participantes; ?>" disabled/>
              </div>

            </div>

            <br />

            <div class="row">
              <div class="left_data">
                <label class="label_normal"> Beginning Date:</label>
                <input type="date" name ="data_inicio" value ="<?php echo $data_inicio; ?>"  disabled/>
              </div>

              <div class="right">
                <label class="label_normal"> Ending Date:</label>
                <input type="date" name ="data_fim"    value ="<?php echo $data_fim; ?>" disabled/>
              </div>

            </div>

            <br />

            <div class="row">
              <label class="label_normal" > Highlights:</label>
              <input type="text"  name ="highlight1" value ="<?php echo $highlight1; ?>" class="create_project3" <?php if (!$erro){ echo "disabled";} ?> />

              <label class="label_normal" ></label>
              <input type="text"  name ="highlight2" value ="<?php echo $highlight2; ?>" class="create_project3"  <?php if (!$erro){ echo "disabled";} ?>/>

              <label class="label_normal" ></label>
              <input type="text"  name ="highlight3" value ="<?php echo $highlight3; ?>" class="create_project3"  <?php if (!$erro){ echo "disabled";} ?> />
            </div>

            <div class="row">
              <label class="label_normal" > Requirements:</label>
              <textarea type="requirements"  name ="requirements"  disabled/><?php echo $requirements; ?></textarea>
            </div>

            <input type="hidden" name="projeto_id" value="<?php echo $projeto_id; ?>">

            <div class="row">
              <div class="right">
              <a href="<?php echo $origem;?>" class="button_back" style="margin-right:40px;"><h4>Back</h4></a>

              <?php
              if($data_inicio <= date('Y-m-d')){
                echo "<p class ='aviso' style='margin-right:20px; margin-top:40px;'> It is not possible to edit this project's info. <p>";
              }
              else {
                ?>
                <input type="submit" id="submit" name="submit" style="margin-top:30px;" value="<?php if ($erro){echo "Confirm";}else{echo "Edit info";}?>" />
                <?php
              }
              ?>

              </div>
            </div>

          </form>
        </div>

      </div>

      <!-- Footer -->
      <?php
        include "../../Includes/footer.php";
      ?>

    </div>

</body>
<script type="text/javascript" src="../../Javascript/javascript.js"> </script>
</html>
