  <!DOCTYPE html>
  <?php
    session_start();
    include "../../Includes/opendb.php";
    include "../../Database/project.php";
    include "../../Database/application.php";
    include "../../Database/volunteer.php";
    include "../../Database/feedback.php";

    if(!isset($_SESSION["id"])){
      header("Location: ../Common/form_login.php");
    }
    else {
      $voluntario_id = $_SESSION["id"];
    }

    $name            = "";
    $email           = "";
    $phone_number    = "";
    $country         = "";
    $password        = "";
    $passport_number = "";

    $erro = false;

    //recuperação de valores, se for o caso (ou seja das variaveis em que nao deu erro)//
    if (!empty($_SESSION['msg_erro'] )) {
      $erro=true;
          if (!empty($_SESSION['name'])){
              $name = $_SESSION['name'];
          }

          if (!empty($_SESSION['email'])){
              $email = $_SESSION['email'];
          }

          if (!empty($_SESSION['password'])){
              $password = $_SESSION['password'];
          }

          if (!empty($_SESSION['phone_number'])){
              $phone_number = $_SESSION['phone_number'];
          }

          if (!empty($_SESSION['country'])){
              $country = $_SESSION['country'];
          }

          if (!empty($_SESSION['passport_number'])){
              $passport_number = $_SESSION['passport_number'];
          }
      }
      else {
        $result = get_volunteer_info($voluntario_id);
        $row    = mysqli_fetch_assoc($result);

        $name            = $row["nome"];
        $email           = $row["email"];
        $phone_number    = $row["telemovel"];
        $country         = $row["nacionalidade"];
        $password        = $row["password"];
        $passport_number = $row["bilhete_identidade"];
      }
  ?>

  <html>

  <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" type="text/css" href="../../CSS/stylesheet.css">
      <link rel="stylesheet" type="text/css" href="../../CSS/private_pages.css">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>My Page</title>
      <link rel="icon" type="image/png" href="../../Images/Logo.png"/>
  </head>

  <body>
      <div class="caixa">

        <!-- Navigation Bar -->
        <?php
          include "../../Includes/header.php";
        ?>

        <div class="bigbox">
          <!-- Zona verde à esquerda - EDIT INFO-->
          <div class="sidenav">

            <h1> My Info:</h1>

            <!--mensagem de erro-->
            <?php
            if (!empty($_SESSION['msg_erro'] )) {
              echo "<p class ='aviso'> ".$_SESSION['msg_erro']."<p>";
              $_SESSION['msg_erro'] = NULL;
            }
            ?>

            <form action="../../Actions/Volunteer/action_edit_info.php" method="post" onsubmit="return editavel()">
              <label style="float:left;">Name:</label>
              <input type="text"     class="vol_edit" name="name"            value ="<?php echo $name;?>" <?php if ($erro){ echo "style='border: 1.5px solid red;'";}else{echo "disabled";} ?> />
              <label style="float:left;">Email:</label>
              <input type="email"    class="vol_edit" name="email"           value ="<?php echo $email;?>" <?php if ($erro){ echo "style='border: 1.5px solid red;'";}else{echo "disabled";} ?> />
              <label style="float:left;">Password:</label>
              <input type="password" class="vol_edit" name="password"        value ="<?php echo $password;?>" <?php if ($erro){ echo "style='border: 1.5px solid red;'";}else{echo "disabled";} ?> />
              <label style="float:left;">Passport Number:</label>
              <input type="text"     class="vol_edit" name="passport_number" value ="<?php echo $passport_number;?>" <?php if ($erro){ echo "style='border: 1.5px solid red;'";}else{echo "disabled";} ?> />
              <label style="float:left;">Phone Number:</label>
              <input type="text"     class="vol_edit" name="phone_number"    value ="<?php echo $phone_number;?>" <?php if ($erro){ echo "style='border: 1.5px solid red;'";}else{echo "disabled";} ?> />
              <label style="float:left;">Country:</label>
              <input type="text"     class="vol_edit" name="country"         value ="<?php echo $country;?>" <?php if ($erro){ echo "style='border: 1.5px solid red;'";}else{echo "disabled";} ?>  />

              <input type="submit" id="submit" name="submit" value="<?php if ($erro){echo "Confirm";}else{echo "Edit info";}?>" />
            </form>

            <a href="../../Actions/Authenticate/logout.php" class="button_esq"> <span>  Logout  </span> </a>

          </div>

          <!-- Zona branca à direita-->
          <div class="rightside">

             <!--- projetos futuros --->
            <h1> My next projects:</h1>
            <?php
            $result = projects_of_volunteer($voluntario_id);
            $row    = mysqli_fetch_assoc($result);

            if (!isset($row["projeto_id"])){ //Não ha projetos
                echo "<p class=\"aviso\" style=\"padding-left:50px;\"> No future projects. Check out our projects and choose your favourite! </p>";
            }
            else { //Há projetos
                while(isset($row["projeto_id"])){
            ?>
                <br />
                <div class="voluntario_esquerdo"> <!-- print imagem do projeto -->
                  <img class="proj" src="../../Images/Project_images/<?php if (!empty($row["foto"])) echo $row["foto"]; else echo 'logo.png';?>" />
                </div>

                <div class="voluntario_direito" ><!-- print info do projeto -->
                  <h2 style="text-align:left;"> <?php echo $row["nome_projeto"]?></h2>
                  <?php
                    $data = date("jS F Y", strtotime($row["data_inicio"]));
                    $data = $data. " to " .date("jS F Y", strtotime($row["data_fim"]));
                  ?>
                  <p style="color:rgb(56, 87, 35);"> <b> Dates: </b> <span style="color:black;"><?php echo $data;?> </span></p>
                  <p style="color:rgb(56, 87, 35);"> <b> Location: </b> <a class="link" href ="<?php echo $row["link_gmaps"];?>" target="_blank"><?php echo $row["nome_cidade"]. ", " .$row["pais"];?> </a> </p>

                  <!-- opções da inscrição -->
                  <a href="../Common/project_info.php?id=<?php echo $row["projeto_id"];?>" class="button_vol" > <span>  More info  </span> </a>
                  <a href="form_apply_to_project.php?info_id=<?php echo $row["projeto_id"];?>" class="button_vol" > <span>  My Application  </span> </a>
                  <br />
                  <a href="../../Actions/Volunteer/action_cancel_application.php?id=<?php echo $row["projeto_id"];?>" class="button_vol" id="grande" onclick="aviso_cancelado()"> <span>  Cancel Application  </span> </a>
                </div>
                  <?php
                  $row    = mysqli_fetch_assoc($result);
                }
            }

             //projetos passados//
            $result = past_projects($voluntario_id);
            $row    = mysqli_fetch_assoc($result);

            if (isset($row["projeto_id"])){ //se há projetos passados, faz print dos projetos passados
                  ?>
              <hr id="vol"/>

              <h1> Past projects:</h1>
              <?php
              while(isset($row["projeto_id"])){
              ?>
                  <br />
                  <div class="voluntario_esquerdo">
                    <img class="proj" src="../../Images/Project_images/<?php if (!empty($row["foto"])) echo $row["foto"]; else echo 'logo.png';?>" />
                  </div>

                  <div class="voluntario_direito" >
                    <h2 style="text-align:left;"> <?php echo $row["nome_projeto"]?></h2>

                    <?php
                      $data = date("jS F Y", strtotime($row["data_inicio"]));
                      $data = $data. " to " .date("jS F Y", strtotime($row["data_fim"]));
                    ?>
                    <p style="color:rgb(56, 87, 35);"> <b> Dates: </b> <span style="color:black;"><?php echo $data;?> </span></p>
                    <p style="color:rgb(56, 87, 35);"> <b> Location: </b> <a class="link" href ="<?php echo $row["link_gmaps"];?>" target="_blank"><?php echo $row["nome_cidade"]. ", " .$row["pais"];?> </a> </p>

                    <!-- opções -->
                    <a href="../Common/project_info.php?id=<?php echo $row["projeto_id"];?>" class="button_vol" > <span>  More info  </span> </a>
                    <a href="form_apply_to_project.php?info_id=<?php echo $row["projeto_id"];?>" class="button_vol" > <span>  My Application  </span> </a>
                    <br />

                    <?php //Verifica se já foi dado feedback ao projeto
                    $num_registos = search_feedback($row["projeto_id"]);

                    if ($num_registos==0){ //se não tiver sido dado feedback
                    ?>
                    <a href="#" onclick="open_form(<?php echo $row["projeto_id"];?>)" class="button_vol" id="verde"> <span>  Leave feedback!  </span> </a>

                    <!--zona de feedback-->
                    <div class="form-popup" id="<?php echo $row["projeto_id"];?>">
                      <form action="../../Actions/Volunteer/action_create_feedback.php" method="post" class="form-container" >
                        <h2>Leave your feedback!</h2>
                        <textarea name="testemunho" id="testemunho" minlength="30" maxlength="500" onkeyup="count(this);"  placeholder="Write your feedback to <?php echo $row["nome_projeto"];?> project"></textarea>

                        <div id="the-count">
                          <P>
                            <span id="current">0</span>
                            <span id="maximum">/ 500</span>
                          </P>
                        </div>
                        <input type ="hidden" name ="projeto_id"  value="<?php echo $row["projeto_id"]; ?>" />
                        <button type="submit" name="submit" class="btn" >Submit</button>
                        <button type="button" class="btn cancel" onclick="close_form(<?php echo $row["projeto_id"];?>)">Close</button>
                      </form>
                    </div>

                    <?php
                  }
                  else { //se já tiver sido deixado o feedback
                    ?>
                    <button id="blocked">You have already left your feedback </a>
                      <?php
                    }
                      ?>
                  </div>

                  <?php
                  $row    = mysqli_fetch_assoc($result);
                }
            }
                  ?>
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
