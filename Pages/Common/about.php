<!-- Página About Us -->
<!DOCTYPE html>
<?php
session_start()
 ?>
<html>

<head>

  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="../../CSS/stylesheet.css">
  <link rel="stylesheet" type="text/css" href="../../CSS/page_list_projects.css">
  <link rel="stylesheet" type="text/css" href="../../CSS/page_index.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us</title>
  <link rel="icon" type="image/png" href="../../Images/Logo.png"/>

</head>

<body>

  <div class="caixa">

    <!-- Navigation Bar -->
    <?php
      include "../../Includes/header.php";
    ?>

    <!-- Imagem c/título  -->
    <div class="container">
      <img class="head" src="../../Images/Backgrounds/background_about.jpg" alt="Volunteering Team" >
      <div class="centered"> <h3> About Us </h3> </div>
    </div>

    <!-- Zona de conteudo  -->
    <div class="whitepart">

      <div class= "row">

        <div class= "columnleft"> <!-- Zona do logo  -->
          <img class="about" src="../../Images/Logo.png" alt="Logo">
          <h2> Nature Heroes </h2>
        </div>

        <div class= "columnleft2"> <!-- texto  -->
          <p class="espaco">Nature Heroes’ mission is to change the face of volunteer travel. Established in 2017, we focus on creating volunteering programs that tackle issues related to Nature, Animals and the Environment. We have projects in Madagascar, Indonesia and Sri Lanka, and are trying to increase our scope worldwide to other developing countries. Our programs include reforestation of protected areas, plant crops for sustainable farming or maintain jungle trails in native forests. We also have programs related to marine conservation, such as helping clean the oceans, and preservation of coasts, oceans and marine landscapes!  </p>
          <p class="espaco"> We believe in a future where any traveler, anywhere in the world is empowered to make a meaningful difference in the community they are visiting, and we take pride in making this happen. Our programs heighten global awareness and cultural understanding through the skills and expertise taken by volunteers to their host communities, and through the experiences and lessons that volunteers take back to their own countries and cultures.</p>
        </div>

      </div>

      <hr>

    </div>


  <!-- Footer -->
  <?php
    include "../../Includes/footer.php";
  ?>

  </div>
</body>
</html>
