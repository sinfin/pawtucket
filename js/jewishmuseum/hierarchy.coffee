initTree = ->
	window.tree = {}
	window.tree.wrap = $('ul', '#hierarchy-full')
	window.tree.parents = window.tree.wrap.find('.parent')
	# window.tree.wrap.on 'click', '.icons', ->
	# 	li = $(this).parent('.parent')
	# 	return if (li.parents('.parent').length > 0) || (li.hasClass 'loading')
	# 	li.addClass('open loading')
	# 	$.get window.baseUrl + '/index.php/Hierarchy/Show/LoadTree',
	# 		id: li.data('id'),
	# 		(data) ->
	# 			console.log data
	# 			li.addClass('loaded').append data
				
	window.tree.wrap.on 'click', '.open > .icons', (e) ->
		e.stopPropagation()
		li = $(this).parent('.parent')
		return if li.hasClass('closed')
		li.addClass('closed')
				
	window.tree.wrap.on 'click', '.open.closed > .icons', (e) ->
		e.stopPropagation()
		li = $(this).parent('.parent')
		li.removeClass('closed')

$ ->
	initTree()