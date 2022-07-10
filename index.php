<?php
  session_start();
 ?>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="CSS/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="CSS/page_index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Start</title>
    <link rel="icon" type="image/png" href="Images/Logo.png"/>
</head>

<body>

<div class="caixa">

<!-- Navigation Bar -->
<?php
    include "Includes/header.php";
?>

<!-- Imagem c/quadrado e quote -->
<div class="container">
  <img src="Images/Backgrounds/background_index.jpg" alt="Helping" style="width:100%;">
  <div class="centeredstart">  <h3> Act as if what you do makes a difference.  <br> It does. </h3> </div>
</div>

<!-- Números -->
<div class="whitepart">
<h1> Every year... </h1>
  <div class="flex-container">
    <div class="index"> <img src ="Images/Icons/pessoas.jpg" alt="Volunteers">
      <h1> 250</h1>
      <h2> Volunteers </h2>
    </div>

    <div class="index"> <img src ="Images/Icons/floresta.jpg" alt="Projects">
      <h1> 15</h1>
      <h2>  Projects </h2>
    </div>

    <div class="index"> <img src ="Images/Icons/mapa.jpg" alt="Countries">
      <h1> 3</h1>
      <h2> Countries </h2>
    </div>
  </div>
</div>

<!-- Parallax -->
<div class="parallax"></div>


<!-- Destinations -->
<div class="whitepart" >
  <h1> Our Destinations </h1>

  <div class="flex-container2">
    <div class="container"> <img src ="Images/srilanka.jpg" alt="Sri Lanka"style="width:300px;height:200px;" >
      <div class="overlay">
        <div class="text">Sri Lanka</div>
      </div>
    </div>

    <div class="container"> <img src ="Images/indonesia.jpg" alt="Indonesia"style="width:300px;height:200px;" >
      <div class="overlay">
        <div class="text">Indonesia</div>
      </div>
    </div>

    <div class="container"> <img src ="Images/madagascar.jpg" alt="Madagascar"style="width:300px;height:200px;" >
      <div class="overlay">
        <div class="text">Madagascar</div>
      </div>
    </div>

  </div>

  <!-- Botão -->
  <a href="list_projects.php" class="button" style="width: 250px; display: inline-block;"> <span> <h4> Check out our projects! </h4> </span> </a>

</div>

<div class="zona_verde">
  <h2 > Prepare yourself for an amazing experience! </h2>
  <div class="flex-container3">
    <div class="flex-container4"> <img src ="Images/Icons/globe.png" alt="Globe">
      <h1> 1</h1>
      <h2> Choose a project </h2>
    </div>

    <div class="flex-container4"> <img src ="Images/Icons/place.png" alt="Place">
      <h1> 2</h1>
      <h2>  Secure your place  </h2>
    </div>

    <div class="flex-container4"> <img src ="Images/Icons/plane.png" alt="Plane">
      <h1> 3</h1>
      <h2> Get ready! </h2>
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
