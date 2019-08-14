(($) ->
  'use strict'

  # Make taxonomy checkboxes show and hide programs.
  $update = ->
    $inputs = $ '#study-abroad-filters input'
    $activeInputs = $inputs.filter ':checked'
    $programs = $ '.program'
    if $activeInputs.length is 0
      # Show all programs
      $programs.filter ':hidden'
        .fadeIn()
    else
      # Decide which programs to show.
      activeInputClasses = []
      $activeInputs.each ( index ) ->
        activeInputClasses.push '.' + this.value
      selected = activeInputClasses.join ', '
      $activePrograms = $programs.filter selected
      # Show or hide programs.
      $activePrograms.fadeIn()
      $programs.not selected
        .fadeOut()
  $reset = (e) ->
    e.preventDefault();
    $inputs = $ '#study-abroad-filters input'
    $activeInputs = $inputs.filter ':checked'
    $activeInputs.each (i) ->
      $(this).prop 'checked', false
    $update()
  $update()
  $('#study-abroad-filters input').on 'change', $update
  $('.reset-search').on 'click', $reset
  return
) jQuery
