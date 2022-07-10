<!DOCTYPE html>
<?php
  session_start();
  include "../../Includes/opendb.php";
  include "../../Database/feedback.php";

  if(!isset($_SESSION["id"]) || ($_SESSION["id"]<>6)){
    header("Location: ../Common/form_login.php");
  }

?>

<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../CSS/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../../CSS/private_pages.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Feedbacks</title>
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
          <h1> Approve/Reject feedbacks </h1>

          <br />
          <?php
          $result = feedbacks_to_approve();
          $row    = pg_fetch_assoc($result);

          if (!isset($row["testemunho"])){
            echo "<p class=\"aviso\"> No new feedbacks to accept/reject. </p>";
          }
          else {
            while (isset($row["testemunho"])){

              $data = date("jS F Y", strtotime($row["data_inicio"]));
              $data = $data. " to " .date("jS F Y", strtotime($row["data_fim"]));
               ?>
              <div class="feedbacks">
                <a class="more_info" href="form_edit_project.php?from_feedback_id=<?php echo $row["projeto_id"];?>" ><?php echo $row["nome_projeto"]. ", ".$data;?></a>
                <br />
                <p> <?php echo $row["testemunho"];?></p>

                <form action="../../Actions/Manager/action_approve_feedback.php" method="post">
                  <input type="hidden" name="projeto_id" value="<?php echo $row["projeto_id"];?>" />
                  <input type="hidden" name="voluntario_id" value="<?php echo $row["voluntario_id"];?>" />

                  <button type="submit" class="accept" name="accept" value="accept" onclick="aviso_aceite()"></button>
                  <button type="submit" class="reject" name="reject" value="reject" onclick="aviso_rejeitado()"></button>

                </form>
              </div>

              <?php
              $row = pg_fetch_assoc($result);
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
  <script type="text/javascript" src="../../Javascript/javascript.js"> </script>
</body>
</html>
