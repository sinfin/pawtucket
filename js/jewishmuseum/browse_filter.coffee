initFilter = ->
	w = $('#splashBrowsePanelContent')
	s = $('#browsePanelSearchInput', '#splashBrowsePanel')
	i = $('.browseSelectPanelLink', '#splashBrowsePanel')
	c = $('#itemsNumberSpan')
	c.text i.length
	s.on 'keyup', ->
		unless w.hasClass('working')
			f = i
			w.addClass 'working'
			v = $(this).val()
			if v is ''
				f.removeClass('hidden')
			else
				i.addClass('hidden')
				f = i.filter ->
					$(this).text().toLowerCase().indexOf(v) >= 0
				f.removeClass 'hidden'
			c.text f.length
			w.removeClass 'working'

initFilter()