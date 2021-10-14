
import './styles/rotation.css';

var $ = require('jquery');
require('jquery-ui');

// start the Stimulus application
import './bootstrap';
import 'jquery-ui'; 

import 'jquery-ui/themes/base/core.css';
import 'jquery-ui/themes/base/theme.css';
import 'jquery-ui/themes/base/selectable.css';
import 'jquery-ui/ui/core';
import 'jquery-ui/ui/widgets/selectable';
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
    $(".rotation_left_fast").css('height', '0');
    $(".rotation_right_fast").css('height', '0');
    $(".rotation_left").css('height', '0');
    $(".rotation_right").css('height', '0');
    $(".rotation_center").css('height', '0');
    $(".tourniquer").css('margin-top', '340px');
    
  } 
  else if ($(this).width() >= 992) {
    $(".div_post").css('width', '500px');
    $(".div_post").css('height', '400px');
    $(".rotation_left_fast").css('height', '0');
    $(".rotation_right_fast").css('height', '0');
    $(".rotation_left").css('height', '0');
    $(".rotation_right").css('height', '0');
    $(".rotation_center").css('height', '0');
    $(".tourniquer").css('margin-top', '220px');
  } 
  else if ($(this).width() >= 768) {
    $(".div_post").css('width', '400px');
    $(".div_post").css('height', '300px');
    $(".rotation_left_fast").css('height', '0');
    $(".rotation_right_fast").css('height', '0');
    $(".rotation_left").css('height', '0');
    $(".rotation_right").css('height', '0');
    $(".rotation_center").css('height', '0');
  }
  else if($(this).width() >= 576){
    $(".div_post").css('width', '300px');
    $(".div_post").css('height', '200px');
    $(".rotation_left_fast").css('height', '0');
    $(".rotation_right_fast").css('height', '0');
    $(".rotation_left").css('height', '0');
    $(".rotation_right").css('height', '0');
    $(".rotation_center").css('height', '0');
  }
});

//click sur les post left et right
$( ".div_post" ).on("click", function() {

  if($(this).parent().hasClass( "left-slide" ))
      {
        left();
      }
      if($(this).parent().hasClass( "right-slide" ))
      {
        right();
      }
      else{
        console.log("erreur");
      }
});


$( ".rotation_center" ).on("click", function() {
  var wa = $(".mid-slide").children()[0];
  $(wa).css(' transition-delay', '1s');
  $(wa).css('transition-duration', '2s');
  $(wa).css("width", $(window).width()-10 + "px");
  $(wa).css("height", $(window).height() - 80 + "px");
  $(wa).css("margin-top","95px");
  $(".rotation_center").css('display', 'none');
  $(".rotation_right").css('display', 'none');
  $(".rotation_left").css('display', 'none');
  $(".rotation_right_fast").css('display', 'none');
  $(".rotation_left_fast").css('display', 'none');
  $(".btn_close").css('display', 'block');
  $(".descriptionLess").css('display', 'none');
  $(".descriptionMax").css('display', 'block');
  $(".descriptionMax").removeClass("d-none");
  $(".descriptionMax").addClass("d-block");
  
});


$( ".btn_close" ).on("click", function() {
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
});


var interval;
$( ".rotation_left_fast" ).on("mouseenter", function() {
    left();
    interval = setInterval(function() {left();}, 800);
});

$( ".rotation_left_fast" ).on("mouseleave", function() {
  clearInterval(interval);
});

$( ".rotation_left" ).on("mouseenter", function() {
  left();
  interval = setInterval(function() {left();}, 1000);
});

$( ".rotation_left" ).on("mouseleave", function() {
clearInterval(interval);
});

$( ".rotation_right_fast" ).on("mouseenter", function() {
  right();
  interval = setInterval(function() {right();}, 800);
});

$( ".rotation_right_fast" ).on("mouseleave", function() {
clearInterval(interval);
});

$( ".rotation_right" ).on("mouseenter", function() {
  right();
  interval = setInterval(function() {right();}, 1000);
});

$( ".rotation_right" ).on("mouseleave", function() {
clearInterval(interval);
});



$( ".data-article-like" ).on("click", function() {
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
          $(bouton).css('backgroundColor', '#1c1c1c');
        }
        if(output == "success_delete"){
          alert("Vous avez supprimer votre like de cette article");
          $(bouton).css(' transition-delay', '2s');
          $(bouton).css('transition-duration', '4s');
          $(bouton).css('backgroundColor', '#2b2a2a');
        }
        if(output == "error_ego"){
          alert("Tu ne peux pas liker un article que tu as créé");
        }
      }
    });
  });
  







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
          $(bouton).css('backgroundColor', '#1c1c1c');
        }
  
        if(output == "error_impossible"){
          alert("Il n'est pas possible d'enlever son report une fois clicker");
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