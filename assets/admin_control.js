
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





  

