<!DOCTYPE html>
<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/project.php";
  include "../../Database/city.php";

  $error_nome      = false;
  $error_cidade    = false;
  $error_inicio    = false;
  $error_fim       = false;
  $error_pax       = false;
  $error_descricao = false;

  if(!isset($_SESSION["id"]) || ($_SESSION["id"]<>6)){
    header("Location: ../Common/form_login.php");
  }

  /*recuperação de valores, se for o caso*/
  if (!empty($_SESSION['msg_erro'] )) {
        if (!empty($_SESSION['nome_projeto'])){
          	$nome_projeto = $_SESSION['nome_projeto'];
        } else {
            $error_nome   = true;
            $nome_projeto = "";
        }

        if (!empty($_SESSION['cidade_id'])){
            $cidade_id    = $_SESSION['cidade_id'];
        }	else{
            $error_cidade = true;
            $cidade_id    = "";
        }

        if (!empty($_SESSION['data_inicio'])){
            $data_inicio  = $_SESSION['data_inicio'];
        } else {
            $data_inicio  = "";
            $error_inicio = true;
        }

        if (!empty($_SESSION['data_fim'])){
            $data_fim     = $_SESSION['data_fim'];
        } else {
            $data_fim     = "";
            $error_fim    = true;
        }

        if (!empty($_SESSION['erro_duracao'])){
            $error_inicio = true;
            $error_fim    = true;
        }

        if (!empty($_SESSION['max_participantes'])){
            $max_participantes = $_SESSION['max_participantes'];
        }	 else {
            $max_participantes = "";
            $error_pax         = true;
        }

        if (!empty($_SESSION['erro_pax'])){
            $error_pax = true;
        }

        if (!empty($_SESSION['descricao'])){
            $descricao = $_SESSION['descricao'];
        }	 else {
            $descricao = "";
            $error_descricao = true;
        }

        if (!empty($_SESSION['requirements'])) 		 	$requirements = $_SESSION['requirements']; 			   		else $requirements = "";
        if (!empty($_SESSION['highlight1'])) 		   	$highlight1 = $_SESSION['highlight1']; 				      	else $highlight1 = "";
        if (!empty($_SESSION['highlight2'])) 		   	$highlight2 = $_SESSION['highlight2']; 				      	else $highlight2 = "";
        if (!empty($_SESSION['highlight3'])) 		   	$highlight1 = $_SESSION['highlight3']; 				      	else $highlight3 = "";
        if (!empty($_SESSION['foto'])) 		         	$foto = $_SESSION['foto']; 				                  	else $foto = "";

        $_SESSION['nome_projeto']     = NULL;
        $_SESSION['cidade_id']        = NULL;
        $_SESSION['data_inicio']      = NULL;
        $_SESSION['data_fim']         = NULL;
        $_SESSION['max_participantes']= NULL;
        $_SESSION['descricao']        = NULL;
        $_SESSION['requirements']     = NULL;
        $_SESSION['highlight1']       = NULL;
        $_SESSION['highlight2']       = NULL;
        $_SESSION['highlight3']       = NULL;
        $_SESSION['foto']             = NULL;
        $_SESSION['erro_duracao']     = NULL;
        $_SESSION['erro_pax']         = NULL;

    } elseif (isset($_GET["id_base"])) {
        $result=get_project_by_id($_GET["id_base"]);
        $row=pg_fetch_assoc($result);

        $nome_projeto     = $row["nome_projeto"];
        $cidade_id        = $row["cidade_id"];
        $requirements     = $row["requirements"];
        $max_participantes= $row["max_participantes"];
        $highlight1       = $row["highlight1"];
        $highlight2       = $row["highlight2"];
        $highlight3       = $row["highlight3"];
        $descricao        = $row["descricao"];
        $foto             = $row["foto"];
        $data_fim         ="";
        $data_inicio      ="";

        $_SESSION["foto_aux"]= $foto; //indica se for data uma foto de outro projeto, uma vez que nesse caso o nome nao  deve ser alterado
      } else {
        $nome_projeto       = "";
        $cidade_id          = "";
        $data_inicio        = "";
        $data_fim           = "";
        $max_participantes  = "";
        $descricao          = "";
        $requirements       = "";
        $highlight1         = "";
        $highlight2         = "";
        $highlight3         = "";
        $foto               = "";
  }

?>

<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../CSS/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../../CSS/private_pages.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Project</title>
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
          <h1> New Project</h1>

          <br />

          <!--Mensagem de erro-->
          <?php
          if (!empty($_SESSION['msg_erro'] )) {
            echo "<p class ='aviso'> ".$_SESSION['msg_erro']."<p>";
		        $_SESSION['msg_erro'] = NULL;
          }
          ?>

          <!--form-->
          <form action="../../Actions/Manager/action_create_project.php" method="post" enctype="multipart/form-data">

            <div class="row">
              <div class="left">
                <label class="label_normal"> Project Name:</label>
                <input type="text" name ="nome_projeto" value ="<?php echo $nome_projeto; ?>" id="create_project1" style="<?php if ($error_nome){ echo 'border: 1.5px solid red;';} ?>" />
              </div>

              <div class="right">
                <label class="label_numero"> Maximum Number of Spots:</label>
                <input type="integer" name ="max_participantes"  value ="<?php echo $max_participantes; ?>" <?php if ($error_pax) echo 'style= "border: 1.5px solid red;"'; ?>/>
              </div>
            </div>

            <br />

            <label class="label_normal"> Description: </label>
            <textarea type="descricao" maxlength="750" name ="descricao" <?php if ($error_descricao) echo 'style= "border: 1.5px solid red;"'; ?>/><?php echo $descricao;?></textarea>

            <br />

            <div class="row">
              <div class="left">
                <label  class="label_normal"> Location: </label>
                <select name = "cidade_id" style="<?php if ($error_cidade){ echo 'border: 1.5px solid red;';} ?> ">
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
                <label class="label_numero"> Photo: </label>
                <input type="file" name="foto" id="file" class="inputfile" accept="image/*" onchange="muda_nome()"/>
                <label id="file_label" for="file"><?php if(isset($_SESSION["foto_aux"]) && (!empty($_SESSION["foto_aux"]))) echo "Photo chosen"; else echo "Choose a photo";?></label>
              </div>

            </div>

            <br />

            <div class="row">
              <div class="left_data">
                <label class="label_normal"> Beginning Date:</label>
                <input type="date" name ="data_inicio" value ="<?php echo $data_inicio; ?>" <?php if ($error_inicio) echo 'style= "border: 1.5px solid red;"'; ?> min="<?php echo date('Y-m-d');?>"/>
              </div>

              <div class="right">
                <label class="label_normal"> Ending Date:</label>
                <input type="date" name ="data_fim" value ="<?php echo $data_fim; ?>" <?php if ($error_fim) echo 'style= "border: 1.5px solid red;"'; ?> min="<?php echo date('Y-m-d');?>"/>
              </div>

            </div>

            <br />

            <div class="row">
              <label class="label_normal" > Highlights:</label>
              <input type="text"  name ="highlight1" value ="<?php echo $highlight1; ?>" class="create_project3"/>

              <label class="label_normal" ></label>
              <input type="text"  name ="highlight2" value ="<?php echo $highlight2; ?>" class="create_project3"  />

              <label class="label_normal" ></label>
              <input type="text"  name ="highlight3" value ="<?php echo $highlight3; ?>" class="create_project3"   />
            </div>

            <div class="row">
              <label class="label_normal" > Requirements:</label>
              <textarea type="requirements"  name ="requirements"  /><?php echo $requirements; ?></textarea>
            </div>

            <br/>

            <div class="row">
              <div class="right">
                <input type ="submit" value="Cancel" name="cancelar" />
                <input type ="submit" value="Create Project" name="criar" style="margin-right:40px;" />
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
