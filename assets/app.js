import './styles/app.scss';
import 'bootstrap';
import './bootstrap';
import 'jquery-ui/ui/widgets/autocomplete'; 
import 'jquery-ui/demos/demos.css'; 

import 'jquery-ui/themes/base/tooltip.css'; 
import 'jquery-ui/themes/base/base.css'; 
import 'jquery-ui/themes/base/core.css';
import 'jquery-ui/themes/base/theme.css';
import 'jquery-ui/themes/base/selectable.css';
import 'jquery-ui/themes/base/autocomplete.css';

import 'jquery-ui/ui/core';
import 'jquery-ui/ui/widgets/selectable';


import bsCustomFileInput from 'bs-custom-file-input';
bsCustomFileInput.init();

var $ = require('jquery');
// require('jquery-ui');

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

      $(".text_color").removeClass("color_white");
      $(".text_color").addClass("color_black");


      $(".user_block_article").removeClass("block_informations_sombre");
      $(".user_block_article").addClass("block_informations_clair");
  
      $(".color_user_profil").removeClass("color_blue");
      $(".color_user_profil").addClass("color_black");

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

      $(".text_color").removeClass("color_black");
      $(".text_color").addClass("color_white");

      $(".user_block_article").removeClass("block_informations_clair");
      $(".user_block_article").addClass("block_informations_sombre");

      $(".color_user_profil").removeClass("color_black");
      $(".color_user_profil").addClass("color_blue");

    }
  }
});
});

$( ".text_left" ).on("click", function() {

    $("#article_description").removeClass( "text-end");
    $("#article_description").removeClass( "text-center");
    $("#article_description").addClass( "text-start")

});

$( ".text_center" ).on("click", function() {

    $("#article_description").removeClass( "text-end");
    $("#article_description").removeClass( "text-start");
    $("#article_description").addClass( "text-center")

});

$( ".text_right" ).on("click", function() {

    $("#article_description").removeClass( "text-start");
    $("#article_description").removeClass( "text-center");
    $("#article_description").addClass( "text-end");

});



$( function() {
  $( "#tags" ).autocomplete({

      source: function( request, response ) {
        $.ajax({
          url: Routing.generate("search_user", {userName: request.term}), 
          dataType: "json",
          success: function( data ) {
            response($.map(data, function (item) {
            
              return {
                label: item.name,
                value: item.name
            };
              
          }));
          }
        });
      },

      select: function( event, ui ) { 

        $.ajax({
  
          url: Routing.generate("search_user_by_name", {userName: ui["item"]["label"]}),  //Cible du script coté serveur à appeler 
          
          success : function (output) {
            if(output == "error")
            {
              window.document.location = Routing.generate('article_index');
            }
            else
            {
              window.document.location = Routing.generate('user_show', {id: output});
            }
            
          }
        });

       },      

  });
});
$( ".tags" ).on( "menufocus", function( event, ui ) {console.log("hey")} );
  // $( "#tags" ).on("keyup", function(event) {
  //   var userName = $('#tags').val();
  //   console.log(userName);
  //   $.ajax({
  
  //     url: Routing.generate("search_user", {userName: userName}),  //Cible du script coté serveur à appeler 
      
  //     success : function (output) {
  //       console.log(output);
  //       $( "#tags" ).autocomplete({
   
  //             source: output,
  //             select: function( event, ui ) {console.log(ui);}
              
  //       });

  //     }
  //   });
  // });
