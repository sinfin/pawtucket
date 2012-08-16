
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

createDialog = (el) ->
	el.dialog
		modal: true
		width: 335
		draggable: false
		resizable: false
		minHeight: 0
		open: ->
			$(this).parents('.ui-dialog').css
				left: '50%'
				marginLeft: -335/2
		close: ->
			$(this).remove()

notifications = ->
	n = $('#notification-src')
	$('body').on 'click', '.ui-widget-overlay, .ui-dialog .close.ico-close', ->
		 $('.ui-dialog-titlebar-close').trigger('click')
	if n.length is 1
		n.append('<span class="close ico-close"></span>')
		createDialog n

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

cstypo = ->
	if $('html').hasClass('lang-cs')
		$('p, li, div').add('.footer-left a').cstypo()

cancelLazyload = ->
	$('.lazyload').trigger('appear')
	unless typeof window.loadImg is 'undefined'
		window.loadImg $('ul li', '#tab-images')
		console.log $('ul li', '#tab-images')

printPage = (notification) ->
	element = $('<div class="notification"></div>').html(notification).append('<span class="close ico-close"></span>')
	createDialog element
	cancelLazyload()
	window.print()

bindPrint = ->
	$('body').on 'click', '.print-page', ->
		printPage $(this).data('notification')

$ ->
	window.equalHeight($('.equal-height, .grid > ul'))
	fixSidebar()
	cstypo()
	notifications()
	protectImgs()
	togglable()
	videos()
	protectEmails()
	bindPrint()
	# initMasonry()
