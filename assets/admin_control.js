
import 'jquery-ui'; 

import 'jquery-ui/themes/base/core.css';
import 'jquery-ui/themes/base/theme.css';
import 'jquery-ui/themes/base/selectable.css';
import 'jquery-ui/ui/core';
import 'jquery-ui/ui/widgets/selectable';

var $ = require('jquery');
require('jquery-ui');

$( ".set_admin" ).on("change", function() {
  var admin = $(this);
  var ad = this;
  var idUser = $(this).attr('id');
  // if (admin.is(':checked')){
  //   alert('check');
  // }
  // else{
  //   alert('not check');
  // }
  $.ajax({

    url: Routing.generate("user_change_role", {idUser: idUser}),  //Cible du script coté serveur à appeler 
    
    success : function (output) {
      console.log(output);
      if(output == "success_check"){
        alert("Vous avez ajouter le droit d'administrateur à cet utilisateur");
        $(ad).prop( "checked", true )
      }

      if(output == "success_uncheck"){
          alert("Vous avez enlevé le droit d'administrateur à cet utilisateur");
          $(ad).prop( "checked", false )
      }

      if(output == "action_interdite"){
        alert("Cette action est interdite");
      }
    }
  });
});







$( ".set_blocked" ).on("change", function() {
  var admin = $(this);
  var ad = this;
  var idUser = $(this).attr('id');
  // if (admin.is(':checked')){
  //   alert('check');
  // }
  // else{
  //   alert('not check');
  // }
  $.ajax({

    url: Routing.generate("user_change_blocked", {idUser: idUser}),  //Cible du script coté serveur à appeler 
    
    success : function (output) {
      console.log(output);
      if(output == "success_blocked"){
        alert("Vous avez bloqué l'utilisateur");
        $(ad).prop( "checked", true )
      }

      if(output == "success_unblocked"){
          alert("Vous avez débloqué l'utilisateur");
          $(ad).prop( "checked", false )
      }

      if(output == "action_interdite"){
        alert("Cette action est interdite");
      }
      
    }
  });
});


$( ".choose_status" ).on("change", function() {

  var ad = this;
  var idSupport = $(this).attr('id');
  var value;
  value = $("option:selected", this).attr('value');

  console.log(value);
  if(value != "EnAttente" && value != "EnCours" && value != "Resolu" && value != "Abandon" )
    { alert("arrete ca petit malin et recharge la page"); }
  else{
    $.ajax({
      url: Routing.generate("change_status", {idSupport: idSupport, value: value}),  //Cible du script coté serveur à appeler 
      
      success : function (output) {
        console.log(output);
        if(output == "success"){
          alert("Changement de status");
        }
        if(output == "error"){
          alert("arrete ca petit malin et recharge la page");
        }
      }
    });
  }

});



$(window).resize(function() {
  
  if ($(this).width() >= 1400) {
    $(".size_table_admin").css('max-height', '77vh');
  } 
  else if ($(this).width() < 1400) {
    $(".size_table_admin").css('max-height', '38vh');
  } 
});

  

