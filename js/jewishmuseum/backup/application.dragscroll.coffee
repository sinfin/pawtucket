initReader = -> 
	window.scrollTimer = false
	r = window.reader
	r.height($(window).height() - 55)
	$(window).scrollTop(0).scrollTop(r.parent('#images').offset().top - 15);
	r.dragscrollable(
		dragSelector: 'li'
	)
	
	window.offsets = []
	r.find('li').each (index) ->
		window.offsets[index] = $(this).position().top
	
	count = r.find('li').length
	
	createPagination count

	$(window).resize(->
		r.height($(window).height() - 55)
	)

createPagination = (count) ->
	options = []
	offsets = window.offsets
	options[num] = '<option value="' + num + '">Page #' + num + '</option>' for num in [1..count]
	window.reader.before('<div id="detail-left-pagination"><select name="pagination" id="detail-left-select">' + options.join('') + '</select></div>')
	window.readerSelect = $('#detail-left-select', '#detail-left')
	window.readerSelect.bind 'change', ->
		window.reader.scrollTop(offsets[$(this).val() - 1])
	
	window.reader.bind 'scroll', ->
		clearTimeout window.scrollTimer if window.scrollTimer
		window.scrollTimer = setTimeout(->
			window.reader.trigger 'scrollchange'
		, 200)
		
	window.reader.bind 'scrollchange', ->
		o = $(this).scrollTop()
		n = 0
		n++ while (n < offsets.length && (offsets[n] + window.reader.height()/2) < o)
		window.readerSelect.val(n+1)
	
$ ->
	window.reader = $('> ul', '#images')
	# initReader() if window.reader.length is 1