var slideIndex = 1;

//accordion da pagina de info dos projetos
function abrir_more_info(){
  var acc = document.getElementsByClassName("accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    });
  }

  showSlides(slideIndex);
}


//slideshow de fotos - pagina info de projeto
function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" activo", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " activo";
}


//para pagina principal do voluntario
function editavel(){
  var submit = document.getElementById("submit");
  var input = document.getElementsByClassName("vol_edit");

  if(submit.value == "Confirm"){
    return true;
  }

  input[0].disabled = false;
  input[1].disabled = false;
  input[2].disabled = false;
  input[3].disabled = false;
  input[4].disabled = false;
  input[5].disabled = false;

  document.getElementById("submit").value = "Confirm";
  return false;
}


//para pagina de criar projetos do manager
function editavel_manager(){
  var submit = document.getElementById("submit");
  var input = document.getElementsByClassName("proj_edit");

  if(submit.value == "Confirm"){
    return true;
  }

  input[0].disabled = false;
  input[1].disabled = false;

  var input = document.getElementsByClassName("create_project3");

  input[0].disabled = false;
  input[1].disabled = false;
  input[2].disabled = false;

  document.getElementById("submit").value = "Confirm";
  return false;
}


//pop-up do voluntario para deixar feedback
function open_form(html_id){
    document.getElementById(html_id).style.display = "block";
}

function close_form(html_id) {
  document.getElementById(html_id).style.display = "none";
}


//contador que vê o numero de caracteres do feedback
function check_length(){
  var str = document.getElementById("text_feedback").value.length;
  if(str>=30 && str<=500){
      return true;
  }else{
      return false;
  }
}


 //botão de submit photo da pagina de criar projetos do manager
function count(obj){
  var str= obj.value.length;
  document.getElementById("current").innerHTML=str;
}

function muda_nome(){
  document.getElementById("file_label").innerHTML="Photo chosen";
}


//quando manager aceita/rejeita feedback
function aviso_aceite(){
  alert("Feedback successfully accepted");
}

function aviso_rejeitado(){
  alert("Feedback successfully rejected");
}


//quando voluntario cancela a sua inscricao num projeto
function aviso_cancelado(){
  alert("Cancellation made successfully");
}


//sign up
function validaPassword(password){

  var msg = document.getElementById("msg");
  var out_div = document.getElementById("out-div");
  var in_div = document.getElementById("in-div");

  if(password.length == 0)
  {
    msg.innerHTML = "";
    out_div.style.display = "none";
  }
  else {
    out_div.style.display = "block";
  }

  var matchedCase = new Array();
  matchedCase.push("[$@$!%*#?&~^´`«»º ª|]"); // Special Charector
  matchedCase.push("[A-Z]"); // Uppercase Alpabates
  matchedCase.push("[0-9]"); // Numbers
  matchedCase.push("[a-z]"); // Lowercase Alphabates

  var ctr = 0;
  for (var i = 0; i < matchedCase.length; i++) {
    if (new RegExp(matchedCase[i]).test(password)) {
      ctr++;
    }
  }

  var msg_aux = "";
  var color = "";
  var width = "";
  switch (ctr) {
    case 1:
    color = "#ba2d23";
    width = "25%";
    break;
    case 2:
    color = "orange";
    width = "50%";
    break;
    case 3:
    color = "yellow";
    width = "75%";
    break;
    case 4:
    color = "green";
    width = "100%";
    break
  }

  msg.style.color = color;


  in_div.style.width = width;
  in_div.style.backgroundColor =color;
}
