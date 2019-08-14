(function($) {
  'use strict';
  var $reset, $update;
  // Make taxonomy checkboxes show and hide programs.
  $update = function() {
    var $activeInputs, $activePrograms, $inputs, $programs, activeInputClasses, selected;
    $inputs = $('#study-abroad-filters input');
    $activeInputs = $inputs.filter(':checked');
    $programs = $('.program');
    if ($activeInputs.length === 0) {
      // Show all programs
      return $programs.filter(':hidden').fadeIn();
    } else {
      // Decide which programs to show.
      activeInputClasses = [];
      $activeInputs.each(function(index) {
        return activeInputClasses.push('.' + this.value);
      });
      selected = activeInputClasses.join(', ');
      $activePrograms = $programs.filter(selected);
      // Show or hide programs.
      $activePrograms.fadeIn();
      return $programs.not(selected).fadeOut();
    }
  };
  $reset = function(e) {
    var $activeInputs, $inputs;
    e.preventDefault();
    $inputs = $('#study-abroad-filters input');
    $activeInputs = $inputs.filter(':checked');
    $activeInputs.each(function(i) {
      return $(this).prop('checked', false);
    });
    return $update();
  };
  $update();
  $('#study-abroad-filters input').on('change', $update);
  $('.reset-search').on('click', $reset);
})(jQuery);
