initMasonry = ->
	settings =
		columnWidth: 50
		# gutterWidth: 40
		itemSelector: '.visible'
		isAnimated: true

	wrap = $('> ul', '#setItemsGrid')
	
	wrap.find('img').filter('[data-ratio]').each ->
		t = $(this)
		w = t.width()
		t.css
			width: w
			height: w/parseFloat(t.data('ratio'))

	wrap.masonry settings
	# wrap.isotope()
	# 	masonry:
	# 		columnWidth: 10
	# 		gutterWidth: 0

initSearch = -> 
	s = $('.submit', '#online-exhibition-search')
	return unless s.length is 1
	wrap = $('ul', '#setItemsGrid')
	items = wrap.children('.setItem')
	countWrap = $('.results-count', '#online-exhibition-search')
	count = countWrap.children('.count')
	setTimeout ->
		hs = wrap.find('.h2, .textContent')
		i = s.siblings('input')

		s.on 'click', ->
			return false if wrap.hasClass('working')
			v = i.val().toLowerCase()
			wrap.addClass('working')
			if v is ''
				show = items
				countWrap.removeClass('in')
			else
				show = hs.filter(-> return $(this).text().toLowerCase().indexOf(v) >= 0)
				show = show.parents('.setItem')
				count.text show.length
				countWrap.addClass('in')
			items.not(show).removeClass('visible')
			show.addClass('visible')
			wrap.masonry 'reload'
			wrap.removeClass 'working'
			$(window).trigger 'resize' # refresh lazyload
		i.on 'keyup', (e) ->
			if e.keyCode is 27 # esc
				i.val('')
				s.trigger('click')
			s.trigger('click') if e.keyCode is 13 # enter
	, 400
		
$ ->
	initMasonry()
	initSearch()