
# initLess = -> 
	# less.env = "development"
	# less.watch()

protectEmails = ->
	$('.em').filter('[data-em]').each ->
		t = $(this)
		e = t.data('em').replace '/', '@'
		t.attr('href', 'mailto:'+e).not('.custom-text').text e

window.equalHeight = (container)	->
	container.each(->
		thisCont = $(this)
		thisCont.imagesLoaded(-> 
			window.equalHeightDo thisCont.children()
		)	
	)

window.equalHeightDo = (children) -> 
	tallest = 0
	children.each(-> 
		th = $(this).height()
		tallest = th if tallest < th
	)
	children.height(tallest)
	return tallest

togglable = ->
	$('.toggle').on 'click', (e) ->
		e.preventDefault()
		$(this).toggleClass('in').next('.togglable').toggleClass('in')
	$('.togglable').on 'click', '.close', ->
		$(this).parents('.togglable').toggleClass('in').prev('.toggle').toggleClass('in')

# initMasonry = -> 
	# settings =
		# itemSelector: 'li'
		# columnWidth: 300
		# gutterWidth: 20
		# isAnimated: true
	# container = $('.grid').children('ul')

	# container.imagesLoaded(-> 
		# container.masonry(settings)
	# )
fixSidebar = ->
	d = $('#detail')
	if d.length is 1
		d.css(
			minHeight: d.children('#detail-right').outerHeight() + 36
		)
	
protectImgs = ->
	$('#tab-images').on 'contextmenu', 'img', (e) ->
		e.preventDefault()
		return false

notifications = ->
	n = $('#notification-src')
	if n.length is 1
		$('body').on 'click', '.ui-widget-overlay', ->
			 $('.ui-dialog-titlebar-close').trigger('click')
		n.dialog
			modal: true
			width: 335
			draggable: false
			resizable: false
			minHeight: 0
			open: (event, ui) ->
				console.log $(this).parents('.ui-dialog')
				$(this).parents('.ui-dialog').css
					left: '50%'
					marginLeft: -335/2

videos = ->
	swfLocation = "#{ window.baseUrl }/viewers/apps/flowplayer-3.2.7.swf"
	wrap = $('#detail-left')
	resizeRatio = (el, wrap) ->
		r = parseFloat(el.data('ratio'))
		el.css
			display: 'block'
			width: wrap.width()
			height: wrap.width()/r
	$('.video-me').each ->
		t = $(this)
		id = t.attr('id')
		if t.is('.ratio-resize[data-ratio]')
			resizeRatio t, wrap
		flowplayer id, swfLocation
	$(window).on 'resize', ->
		$('.ratio-resize').filter('[data-ratio]').each ->
			resizeRatio $(this), wrap

printHandler = ->
	window.onbeforeprint = ->
		alert('print!')

cstypo = ->
	if $('html').hasClass('lang-cs')
		$('p, li, div').add('.footer-left a').cstypo()

$ ->
	$(window).on 'load', ->
		$(window).trigger('resize')
	window.equalHeight($('.equal-height, .grid > ul'))
	fixSidebar()
	cstypo()
	notifications()
	protectImgs()
	togglable()
	videos()
	protectEmails()
	printHandler()
	# initMasonry()
