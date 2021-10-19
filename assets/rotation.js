
import './styles/rotation.scss';

var $ = require('jquery');
require('jquery-ui');

import 'bootstrap';
import './bootstrap';
import 'jquery-ui'; 
import 'jquery-ui/themes/base/core.css';
import 'jquery-ui/themes/base/theme.css';
import 'jquery-ui/themes/base/selectable.css';
import 'jquery-ui/ui/core';
import 'jquery-ui/ui/widgets/selectable';
import bsCustomFileInput from 'bs-custom-file-input';
bsCustomFileInput.init();

require('bootstrap');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');


var userRating = document.querySelector('.js-user-rating');
var isAuthenticated = userRating.dataset.isAuthenticated;
var variable = parseInt(isAuthenticated) ;
var variable_second_function = variable - 1;
var variable_fix = variable;

let tableauTexte;

function tab(id, texte){
  tableauTexte[id] = texte;
}

var winSize = '';

//test pour les changements de taille ecran
$(window).resize(function() {
  
  if ($(this).width() >= 1200) {
    $(".div_post").css('width', '700px');
    $(".div_post").css('height', '500px');
    $(".tourniquer").css('margin-top', '340px');
    $(".tourniquer").css('z-index', '1');
    $(".rotation_center").css('display', 'block');
    $(".rotation_right").css('display', 'block');
    $(".rotation_left").css('display', 'block');
    $(".rotation_right_fast").css('display', 'block');
    $(".rotation_left_fast").css('display', 'block');
    
  } 
  else if ($(this).width() >= 992) {
    $(".div_post").css('width', '500px');
    $(".div_post").css('height', '400px');
    $(".tourniquer").css('z-index', '3');
    $(".tourniquer").css('margin-top', '220px');
    $(".rotation_center").css('display', 'none');
    $(".rotation_right").css('display', 'none');
    $(".rotation_left").css('display', 'none');
    $(".rotation_right_fast").css('display', 'none');
    $(".rotation_left_fast").css('display', 'none');
  } 
  else if ($(this).width() >= 768) {
    $(".div_post").css('width', '400px');
    $(".div_post").css('height', '300px');
    $(".tourniquer").css('z-index', '3');
    $(".rotation_center").css('display', 'none');
    $(".rotation_right").css('display', 'none');
    $(".rotation_left").css('display', 'none');
    $(".rotation_right_fast").css('display', 'none');
    $(".rotation_left_fast").css('display', 'none');
  }
  else if($(this).width() >= 576){
    $(".div_post").css('width', '300px');
    $(".div_post").css('height', '200px');
    $(".tourniquer").css('z-index', '3');
    $(".rotation_center").css('display', 'none');
    $(".rotation_right").css('display', 'none');
    $(".rotation_left").css('display', 'none');
    $(".rotation_right_fast").css('display', 'none');
    $(".rotation_left_fast").css('display', 'none');
  }
});




$( ".div_post" ).on("click", function() {


  if($(this).parent().hasClass( "left-slide" ))
  {
    left();
    event.stopPropagation();
  }
  else if($(this).parent().hasClass( "right-slide" ))
  {
    right();
    event.stopPropagation();
  }
  else{
    $(".rotation_center").css('display', 'none');
    $(".rotation_right").css('display', 'none');
    $(".rotation_left").css('display', 'none');
    $(".rotation_right_fast").css('display', 'none');
    $(".rotation_left_fast").css('display', 'none');
    var wa = this;
    $(wa).css(' transition-delay', '1s');
    $(wa).css('transition-duration', '2s');
    $(wa).css("width", $(window).width()-10 + "px");
    $(wa).css("height", $(window).height() - 130 + "px");
    $(wa).css("margin-top","65px");

    $(".btn_close").css('display', 'block');
    $(".descriptionLess").css('display', 'none');
    $(".descriptionMax").css('display', 'block');
    $(".descriptionMax").removeClass("d-none");
    $(".descriptionMax").addClass("d-block");
  }
    
  
});


$( ".btn_close" ).on("click", function(event) {

  var wa = $(".mid-slide").children()[0];
  $(wa).css(' transition-delay', '1s');
  $(wa).css('transition-duration', '2s');
  $(wa).css("width", "900px");
  $(wa).css("height", "500px");
  $(wa).css("margin-top", "0px");
  $(".rotation_center").css('display', 'block');
  $(".rotation_right").css('display', 'block');
  $(".rotation_left").css('display', 'block');
  $(".rotation_right_fast").css('display', 'block');
  $(".rotation_left_fast").css('display', 'block');
  $(".btn_close").css('display', 'none');
  $(".descriptionLess").css('display', 'block');
  $(".descriptionMax").removeClass("d-block");
  $(".descriptionMax").addClass("d-none");
  event.stopPropagation();
});


var interval;
$( ".rotation_left_fast, .rotation_left_fast_black" ).on("mouseenter", function() {
    left();
    interval = setInterval(function() {left();}, 800);
});

$( ".rotation_left_fast, .rotation_left_fast_black" ).on("mouseleave", function() {
  clearInterval(interval);
});

$( ".rotation_left, .rotation_left_black" ).on("mouseenter", function() {
  left();
  interval = setInterval(function() {left();}, 1000);
});

$( ".rotation_left , .rotation_left_black" ).on("mouseleave", function() {
clearInterval(interval);
});

$( ".rotation_right_fast, .rotation_right_fast_black" ).on("mouseenter", function() {
  right();
  interval = setInterval(function() {right();}, 800);
});

$( ".rotation_right_fast, .rotation_right_fast_black" ).on("mouseleave", function() {
clearInterval(interval);
});

$( ".rotation_right, .rotation_right_black" ).on("mouseenter", function() {
  right();
  interval = setInterval(function() {right();}, 1000);
});

$( ".rotation_right, .rotation_right_black" ).on("mouseleave", function() {
clearInterval(interval);
});



$( ".data-article-like" ).on("click", function(event) {
    var idArticle = $(this).attr('id');
    var bouton = this;
    $.ajax({
  
      url: Routing.generate("create_like", {idArticle: idArticle}),  //Cible du script coté serveur à appeler 
      
      success : function (output) {
        console.log(output);
        if(output == "success_like"){
          alert("Vous avez liker la publication");
          $(bouton).css(' transition-delay', '2s');
          $(bouton).css('transition-duration', '4s');
          $(bouton).css('backgroundColor', '#383838');
        }
        if(output == "success_delete"){
          alert("Vous avez supprimer votre like de cette article");
          $(bouton).css(' transition-delay', '2s');
          $(bouton).css('transition-duration', '4s');
          $(bouton).css('backgroundColor', 'none');
        }
        if(output == "error_ego"){
          alert("Tu ne peux pas liker un article que tu as créé");
          
        }
      }
    });
    event.stopPropagation();}
  );
  







  $( ".data-article-report" ).on("click", function() {
    var idArticle = $(this).attr('id');
    var bouton = this
    $.ajax({
  
      url: Routing.generate("create_report", {idArticle: idArticle}),  //Cible du script coté serveur à appeler 
      
      success : function (output) {
        console.log(output);
        if(output == "success_report"){
          alert("Vous avez report la publication");
          $(bouton).prop("disabled", true)
          $(bouton).css(' transition-delay', '2s');
          $(bouton).css('transition-duration', '4s');
          $(bouton).css('backgroundColor', '#383838');
        }
  
        if(output == "error_impossible"){
          alert("Il n'est pas possible d'enlever son report une fois clicker");
        }
      }
    });
    event.stopPropagation();
  });






  $('#theme').on('change', function() { 
        // From the other examples
      $.ajax({

        url: Routing.generate("user_change_theme"),  //Cible du script coté serveur à appeler 
        
        success : function (output) {
          console.log(output);
          if(output == "success_theme_claire"){

            alert("sucess change theme");
            $("body").css("background-color", "#bfbfbf");
            $(".footer").css("background-color", "white");
            $(".footer").css("color", "black");
  
            $(".div_post").css("background-color", "#dbdbdb");
            $(".div_post").css("border", "2px solid #474747");
            $(".div_post").css("color", "black");
  
            $("#fast_back").removeClass("rotation_left_fast");
            $("#step_back").removeClass("rotation_left");
            $("#step_for").removeClass("rotation_right");
            $("#fast_for").removeClass("rotation_right_fast");
  
            $("#fast_back").addClass("rotation_left_fast_black");
            $("#step_back").addClass("rotation_left_black");
            $("#step_for").addClass("rotation_right_black");
            $("#fast_for").addClass("rotation_right_fast_black");

            
            
            $(".btn_close").addClass("bouton_close_claire");
            $(".btn_close").removeClass("bouton_close_sombre");
  
            $(".test2").css("background-color", "#474747");
            $(".bouton_options").css("border", "2px solid white");
            $(".color_bouton_options").css("color", "white");

            $(".nav_lil").removeClass("li_sombre");
            $(".nav_lil").addClass("li_claire");

            $(".nav_ulu").removeClass("ul_sombre");
            $(".nav_ulu").addClass("ul_claire");

          }

          else if(output == "success_theme_sombre"){

            alert("sucess change theme sombre");

            $("body").css("background-color", "#2b2a2a");
            $(".footer").css("background-color", "#212529");
            $(".footer").css("color", "white");
    
            $(".div_post").css("background-color", "#2b2a2a");
            $(".div_post").css("border", "2px solid #17a2b8");
            $(".div_post").css("color", "#17a2b8");
    
            $("#fast_back").addClass("rotation_left_fast");
            $("#step_back").addClass("rotation_left");
            $("#step_for").addClass("rotation_right");
            $("#fast_for").addClass("rotation_right_fast");
    
            $("#fast_back").removeClass("rotation_left_fast_black");
            $("#step_back").removeClass("rotation_left_black");
            $("#step_for").removeClass("rotation_right_black");
            $("#fast_for").removeClass("rotation_right_fast_black");
    
            $(".test2").css("background-color", "#4d4d4d");
            $(".bouton_options").css("border", "2px solid #17a2b8");
            $(".color_bouton_options").css("color", "#17a2b8");

            
            $(".btn_close").addClass("bouton_close_sombre");
            $(".btn_close").removeClass("bouton_close_claire");

            $(".nav_lil").removeClass("li_claire");
            $(".nav_lil").addClass("li_sombre");

            $(".nav_ulu").removeClass("ul_claire");
            $(".nav_ulu").addClass("ul_sombre");

          }
        }
      });
  });





function update_number_div(nb)
{
    variable = nb - 1;
    variable_fix = nb-1;
}




  




function left() {
  "use strict";
  
  

    variable = variable + 1;

for (let i = variable_fix + 2 ; i < variable_fix + variable_fix + 2; i++) // cette boucle permet de gerer le fais d'aller à droite si on allez a gauche precedement, permet la gestion de variable à travers les deux  fonctions
{

    if(variable == i)
    {
      variable = i - variable_fix-1;
    }
  
}
//boucle pour aller vers la droite
for (let i = 1 ; i < variable_fix + 2 ; i++) 
{
  
  if (i == 1)
  {
    document.getElementById('slide'+variable).className = "left-slide";
    variable = variable + 1;

    if(variable > variable_fix+1)
    {
      variable = 1;
    }
  }
 
  else if (i == 2)
  {
    document.getElementById('slide'+variable).className = "mid-slide";
    variable = variable + 1;
    if(variable > variable_fix+1)
    {
      variable = 1;
    }
  }
  else if(i == 3)
  {
    document.getElementById('slide'+variable).className = "right-slide";
    variable = variable + 1;
    if(variable > variable_fix+1)
    {
      variable = 1;
    }
  }
  else if(i == variable_fix +1 )
  {
    document.getElementById('slide'+variable).className = "vide";
    variable = variable - 1;
  }
  else
  {
    document.getElementById('slide'+variable).className = "vide";
    variable = variable + 1;
    if(variable > variable_fix+1)
    {
      variable = 1;
    }
  }
}
 
};



function right() {
  "use strict";
  
  variable = variable - variable_second_function;

      var variable_boucle = variable_fix + 2;
    
      for (let i = 0 ; i > -variable_fix; i--) // cette boucle permet de gerer le fais d'aller à gauche si on allez a droite precedement permet la gestion de variable à travers les deux  fonctions
      {     
          variable_boucle = variable_boucle - 1;
          if(variable == i)
          {
       
            variable = variable_boucle;
          }  
      }
    
      for (let i = 1 ; i < variable_fix + 2 ; i++) 
      {
        if (i == variable_fix+1)
        {
          document.getElementById('slide'+variable).className = "left-slide";
          variable = variable + variable_second_function;
        }
       
        else if (i == variable_fix)
        {
          document.getElementById('slide'+variable).className = "mid-slide";
          variable = variable - 1;
          if(variable < 1)
          {
            variable = variable_second_function + 2;
          }
        }
        else if(i == variable_fix - 1)
        {
          document.getElementById('slide'+variable).className = "right-slide";
          variable = variable - 1 ;
          if(variable < 1)
          {
            variable = variable_second_function + 2;
          }
        }
        else
        {
          document.getElementById('slide'+variable).className = "vide";
          variable = variable - 1 ;
          if(variable < 1)
          {
            variable = variable_second_function + 2;
          }
        }
      }

   
 
};