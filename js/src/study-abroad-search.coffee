(($) ->
  'use strict'

  # Make taxonomy checkboxes show and hide programs.
  $update = (e) ->
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
    if typeof e isnt 'undefined' and Foundation.MediaQuery.atLeast 'medium'
      $('#search-sidebar .sticky').foundation('_destroy')
      filters = new Foundation.Sticky( $('#search-sidebar > .wrap') )
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

  # Sticky search filters for mobile
  if Foundation.MediaQuery.is 'small only'
    $('.study-abroad-search-sidebar > .sticky').removeClass('is-at-bottom')
    buttonHeight = $('.study-abroad-toggle').outerHeight()
    $('.study-abroad-search-sidebar #filter-wrap').css('top', buttonHeight + 'px')
    # Set bounds of filter box to allow scrolling
    $wrap = $('.study-abroad-search-sidebar #filter-wrap')
    $filters = $wrap.find('#study-abroad-filters')
    $filters.css('top', ($filters.offset().top - $wrap.offset().top + 16) + 'px')
    # Custom sticky script for mobile
    $(window).scroll (e) ->
      scroll = $(window).scrollTop()
      navheight = $('.site-header').height()
      sidebar = $('.study-abroad-search-sidebar > .sticky').removeClass('is-at-bottom')
      if scroll > navheight
        if sidebar.hasClass('is-stuck') is false
          sidebar.addClass('is-stuck').removeClass('is-anchored').css('top', (navheight + 16) + 'px')
      else
        if sidebar.hasClass('is-stuck') is true
          sidebar.removeClass('is-stuck').addClass('is-anchored').css('top', 0)
      # Fix issue where top position is set to a ridiculously high value on page load
      if parseInt(sidebar.css('top')) > 200
        if sidebar.hasClass('is-stuck')
          sidebar.css('top', (navheight + 16) + 'px')
        else
          sidebar.css('top', '0')
  return
) jQuery
