moveControls = -> 
	c = $('#browseControls')
	if c.length is 1
		$('.browse', '#navigation').addClass('active').append c
	
displayOptions = -> 
	$('#main .content').on 'click', '#display-options a', (e) ->
		e.preventDefault()
		t = $(this)
		t.siblings('input').attr('checked', 'checked')
		t.parents('form').submit()
	$('#main .content').on 'click', '#searchOptionsBox .order', (e) ->
		e.preventDefault()
		h = $(this).attr('href').split('#')
		$('#direction-select').val(h[1]).parents('form').submit()
	
window.initSlider = (slider, items) ->
	count = items.length - 1
	settings =
		max: count
	slider.slider settings
	items.slice(10, count).hide 0
	slider.find('.ui-slider-handle').append('<span class="handle-text"><span id="handle-text-year">'+items.first().find('.browseSelectPanelLink').text()+'</span></span>');
	handle = $('#handle-text-year')
	$('#browsePanelSearch').hide 0
	slider.on 'slide', ->
		v = slider.slider 'value'
		handle.text items.eq(v - 1).find('.browseSelectPanelLink').text()
		v = 6 if v < 6
		v = count if (v + 5) > count
		sh = items.slice (v - 6), (v + 5)
		sh.show 0
		items.not(sh).hide 0

initPagination = ->
	$('#main').on 'click', '.pagination .pagination-link', (e) ->
		e.preventDefault()
		t = $(this)
		url = t.data('url')
		return false if typeof url is 'undefined'
		rb = $('#resultBox')
		return false if rb.hasClass 'loading'
		if t.hasClass 'from-input'
			v = t.siblings('#jumpToPageNum').val()
			return false unless v.length > 0
			url = url + parseInt(v)
		rb.addClass('loading').load url, ->
			rb.removeClass('loading')
			# rb.find('#resultBox').unwrap()
			window.equalHeight($('.grid > ul', '#resultBox'))
		return false

bindFacetLinks = ->
	$('body').on 'click', '.facetLink', (e) ->
		e.preventDefault()
		e.stopPropagation()
		facet = $(this).data('facet')
		unless typeof facet is 'undefined'
			caUIBrowsePanel.showBrowsePanel facet
	
$ ->
	moveControls()
	displayOptions()
	initPagination()
	bindFacetLinks()
