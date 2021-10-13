import 'jquery-ui'; 

import 'jquery-ui/themes/base/core.css';
import 'jquery-ui/themes/base/theme.css';
import 'jquery-ui/themes/base/selectable.css';
import 'jquery-ui/ui/core';
import 'jquery-ui/ui/widgets/selectable';

var $ = require('jquery');

$(window).resize(function() {
  
    if ($(this).height() <= 700) {
      $(".formulaire").css('margin-top', '50px');
      
    } 
    else if($(this).height() >700){
        $(".formulaire").css('margin-top', '210px');
    }
  });