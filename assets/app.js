/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import'./styles/rotation.css';

// start the Stimulus application
import './bootstrap';

var $ = require('jquery');


var variable = 3;

var variable_second_function = variable - 1;

var variable_fix = variable;
// const routes = require('../../public/js/fos_js_routes.json');
// import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

// Routing.setRoutingData(routes);
// Routing.generate('rep_log_list');


$( ".data-article" ).on("click", function() {
  var idArticle = $(this).attr('id');
  
  $.ajax({

    url: Routing.generate("article_like", {id: idArticle}),  //Cible du script coté serveur à appeler 
    
    success : function (output) {
      console.log(output);
      if(output == "success"){
        alert("Vous avez liker la publication");
      }
      if(output == "error_ego"){
        alert("Tu ne peux pas liker un article que tu as créé");
      }
      if(output == "error_delete_like"){
        alert("Vous avez supprimer votre like de cette article");
      }
    }
  });
});


function update_number_div(nb)
{
    variable = nb - 1;
    variable_fix = nb-1;
}


document.addEventListener("DOMContentLoaded", function () {
    "use strict";
   
    var button = document.querySelector("button.left");
    button.addEventListener("click", function (event) {
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
    });
  });


  


  document.addEventListener("DOMContentLoaded", function () {
    "use strict";
   
    var button = document.querySelector("button.right");
    button.addEventListener("click", function (event) {
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
    });
  });

