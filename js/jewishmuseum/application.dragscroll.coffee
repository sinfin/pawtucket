moveRibbons = ->
	oe = $('#detail-online-exhibitions')
	$('#navigation').append(oe) if oe.length is 1

toggleHash = (el) ->
	el.each ->
		t = $(this)
		if t.hasClass('fullscreen-target-hashed')
			t.removeClass('fullscreen-target-hashed')
			h = t.attr('href')
			if h.indexOf('#') > 0
				h = h.substring 0, h.indexOf('#')
				t.attr 'href', h
		else
			t.addClass('fullscreen-target-hashed')
			t.attr 'href', "#{ t.attr('href') }#fullscreen"

loadImgDirect = (img) ->
	orig = img.data 'original'
	unless typeof orig is 'undefined'
		img.not('.loaded').addClass('loaded').attr 'src', orig

loadImg = (els) ->
	fullscreen = $('body').hasClass('fullscreen')
	els.each ->
		t = $(this)
		if fullscreen
			t = t.find('.big .scroll-lazyload')
		else
			t = t.find('.small .scroll-lazyload')
		loadImgDirect t

window.loadImg = loadImg

createPagination = ->
	items = window.imageWrap.find('li')
	count = items.length
	fullscreenLinks = $('.fullscreen-target')
	window.images = items.find('.scroll-lazyload').filter(':visible')
	options = []
	
	generateOffsets = ->
		window.offsets = []
		items.find('.scroll-lazyload').filter(':visible').height('auto').each ->
			t = $(this)
			ratio = t.data 'ratio'
			if ratio
				ratio = parseFloat ratio
				h = t.width()/ratio
				t.height(h)
		items.each (index) ->
			window.offsets[index] = $(this).position().top

	generateOffsets()
	$(window).on 'resize load', generateOffsets
	
	arr = [1..count]
	options[num] = '<option value="' + num + '">' + num + '</option>' for num in arr
	window.readerSelectWrap = $('#detail-left-pagination', window.imageWrap)
	window.readerSelectWrap.prepend('<select name="pagination" id="detail-left-select">' + options.join('') + '</select><span class="arrow-wrap prev"><span class="arrow prev"></span></span><span class="arrow-wrap next"><span class="arrow next"></span></span>')
	window.readerSelect = $('#detail-left-select', window.readerSelectWrap)

	window.readerSelect.on 'change', ->
		window.scrolledBySelect = true
		index = $(this).val() - 1
		item = items.eq(index)
		loadImg items.slice index - 1, index + 1
		$(window).scrollTo(item, 400, { offset: - window.readerSelectWrap.outerHeight() })
	
	window.readerSelectWrap.on 'click', '.arrow-wrap', ->
		c = parseInt window.readerSelect.val()
		if $(this).hasClass('prev')
			c--
		else
			c++
		if ($.inArray(c, arr) > -1)
			window.scrolledBySelect = true
			window.readerSelect.val(c).trigger('change')
	
	$(window).scrollTop(0)
	window.imageWrapTop = window.imageWrap.show(0).offset().top
	fixSelect()
	# window.scrollTimer = false
	
	$(window).on 'scroll', ->
		fixSelect()
		clearTimeout window.scrollTimer if window.scrollTimer
		window.scrollTimer = setTimeout(->
			$(window).trigger 'scrollchange'
		, 200)
		
	$(window).on 'scrollchange', ->
		if window.scrolledBySelect
			window.scrolledBySelect = false
			return false
		offsets = window.offsets
		o = $(window).scrollTop()
		n = 0
		n++ while (n < offsets.length && offsets[n] < o)
		n = 1 if n is 0
		loadImg items.slice n - 1, n + 1
		window.readerSelect.val(n)
	
	# fullscreen toggle
	ft = $('#fullscreen-toggle', window.imageWrap)
	bo = $('body')
	ht = $('html')
	dr = $('#detail-right', '#main')
	si = $('.sidebar', '#main')
	
	showHide = (cont, lIn, rIn, lOut, rOut) ->
		cont.on 'hover', ->
			return if cont.hasClass('in') || !bo.hasClass('fullscreen')
			cont.addClass('in')
			an =
				left: lIn
				right: rIn
			cont.stop().animate an, 600
		cont.on 'mouseleave', ->
			return if !cont.hasClass('in') || !bo.hasClass('fullscreen')
			cont.removeClass('in')
			an =
				left: lOut
				right: rOut
			cont.stop().animate an, 600
	$(window).on 'load', ->	
		showHide si, 0, 'auto', -290, 'auto'
		showHide dr, 'auto', -40, 'auto', -260

	toggleFullscreen = ->
		bo.add(ht).toggleClass('fullscreen')
		ft.toggleClass('in')
		toggleHash fullscreenLinks
		fixSelect()
		si.add(dr).removeAttr('style') # reset all js css
		if ft.hasClass('in')
			window.location.hash = '#fullscreen'
			window.images = items.find('.big .scroll-lazyload')
		else
			window.location.hash = ''
			window.images = items.find('.small .scroll-lazyload')
		$(window).trigger 'resize scroll' # lazyload, window offsets
		window.readerSelect.trigger('change')
		loadImg window.images.slice(0, 1)
		loadImgDirect window.images.eq(0)
		loadImgDirect window.images.eq(1)

	ft.on 'click', toggleFullscreen
	# hash
	h = window.location.hash
	if h is '#fullscreen'
		toggleFullscreen()
	if h is '#text'
		$(window).trigger('resize')
	$(window).on 'load', ->
		$(window).trigger('scroll')
	# doc.ready
	loadImgDirect window.images.eq(0)
	loadImgDirect window.images.eq(1)

fixSelect = ->
	if $(window).scrollTop() > window.imageWrapTop
		window.readerSelectWrap.addClass 'fixed'
		window.readerSelectWrap.width window.imageWrap.width()
		window.readerSelectWrap.css left: window.imageWrap.offset().left
	else
		window.readerSelectWrap.removeClass 'fixed'
		window.readerSelectWrap.removeAttr 'style'

bindTooltips = ->
	$('.item-collections .collection-link', '#detail-right').tooltip
		track: true
		delay: 0
		showURL: false
		positionLeft: true
		bodyHandler: ->
			return $(this).siblings('.description').html()
	
ieFix = ->
	if $.browser.msie and $.browser.version < 9 and $.browser.version > 7
		$('.scroll-lazyload', '#detail-left').css
			maxWidth: 'auto'

$ ->
	ieFix()
	moveRibbons()
	window.imageWrap = $('#tab-images')
	if window.imageWrap.length is 1
		if window.imageWrap.is(':hidden')
			window.imageWrap.one 'activated', createPagination
		else
			createPagination()
	bindTooltips()