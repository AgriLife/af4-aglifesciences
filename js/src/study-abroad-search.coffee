(($) ->
  'use strict'

  # Make taxonomy checkboxes show and hide programs.
  $update = (e) ->
    $inputs = $ '#study-abroad-filters input'
    $activeInputs = $inputs.filter ':checked'
    $items = $ '.program'
    if $activeInputs.length is 0
      # Show all programs
      $items.filter ':hidden'
        .fadeIn()
      $inputs.not ':enabled'
        .removeAttr 'disabled'
    else
      # Decide which items to show.
      activeInputClasses = []
      $activeInputs.each ( index ) ->
        activeInputClasses.push '.' + this.value
      selected = activeInputClasses.join ''
      $activeItems = $items.filter selected
      # Show or hide items.
      $activeItems.fadeIn()
      $items.not selected
        .fadeOut()
      # Find which taxonomies are present in active degrees.
      activeTaxonomies = []
      taxonomies = /study-abroad-(department|region|term|program-type|classification)-\S+/g
      $activeItems.each ->
        matches = this.className.match taxonomies
        j = 0
        while j < matches.length
          if matches[j] not in activeTaxonomies then activeTaxonomies.push '.' + matches[j]
          j++
      activeTaxonomies = activeTaxonomies.join ','
      console.log activeTaxonomies
      # Change enabled state of filters.
      $inputs.filter activeTaxonomies
        .not ':enabled'
        .removeAttr 'disabled'
      $inputs.not activeTaxonomies
        .not ':disabled'
        .attr 'disabled', true
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
  # if Foundation.MediaQuery.is 'small only'
  #   $sidebar = $ '.study-abroad-search-sidebar'
  #   $sidebar.find('> .wrap').removeClass('is-at-bottom').addClass('sticky')
  #   buttonHeight = $('.study-abroad-toggle').outerHeight()
  #   $sidebar.find('#filter-wrap').css('top', buttonHeight + 'px')
  #   # Set bounds of filter box to allow scrolling
  #   $wrap = $sidebar.find('#filter-wrap')
  #   $filters = $wrap.find('#study-abroad-filters')
  #   $filters.css('top', ($filters.offset().top - $wrap.offset().top + 16) + 'px')
  #   # Custom sticky script for mobile
  #   $(window).scroll (e) ->
  #     scroll = $(window).scrollTop()
  #     navheight = $('.site-header').height()
  #     sidebar = $('.study-abroad-search-sidebar > .sticky').removeClass('is-at-bottom')
  #     if scroll > navheight
  #       if sidebar.hasClass('is-stuck') is false
  #         sidebar.addClass('is-stuck').removeClass('is-anchored').css('top', (navheight + 16) + 'px')
  #     else
  #       if sidebar.hasClass('is-stuck') is true
  #         sidebar.removeClass('is-stuck').addClass('is-anchored').css('top', 0)
  #     # Fix issue where top position is set to a ridiculously high value on page load
  #     if parseInt(sidebar.css('top')) > 200
  #       if sidebar.hasClass('is-stuck')
  #         sidebar.css('top', (navheight + 16) + 'px')
  #       else
  #         sidebar.css('top', '0')
  return
) jQuery
