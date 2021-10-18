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
  if (!this.checked) {
      $("body").css("background-color", "#bfbfbf");
      $(".footer").css("background-color", "white");
      $(".footer").css("color", "black");

      $("#nav").removeClass("navbar-dark bg-dark");
      $("#nav").addClass("navbar-light bg-light");

      $(".table").removeClass("table-dark");
      $(".table").addClass("table-light");

  }
  else{

    $("body").css("background-color", "#2b2a2a");
    $(".footer").css("background-color", "#212529");
    $(".footer").css("color", "white");

    $("#nav").addClass("navbar-dark bg-dark");
    $("#nav").removeClass("navbar-light bg-light");

    $(".table").addClass("table-dark");
    $(".table").removeClass("table-light");

    // $("#fast_back").removeClass("rotation_left_fast_black");
    // $("#step_back").removeClass("rotation_left_black");
    // $("#step_for").removeClass("rotation_right_black");
    // $("#fast_for").removeClass("rotation_right_fast_black");

}
});

