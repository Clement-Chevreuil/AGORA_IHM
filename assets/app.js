import './styles/app.scss';
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

var $ = require('jquery');
require('jquery-ui');
require('bootstrap');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');


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

      $("#nav").removeClass("navbar-dark bg-dark");
      $("#nav").addClass("navbar-light bg-light");

      $(".table").removeClass("table-dark");
      $(".table").addClass("table-light");

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
  
      $("#nav").addClass("navbar-dark bg-dark");
      $("#nav").removeClass("navbar-light bg-light");
  
      $(".table").addClass("table-dark");
      $(".table").removeClass("table-light");

      
      $(".nav_lil").removeClass("li_claire");
      $(".nav_lil").addClass("li_sombre");

      $(".nav_ulu").removeClass("ul_claire");
      $(".nav_ulu").addClass("ul_sombre");

    }
  }
});
});
