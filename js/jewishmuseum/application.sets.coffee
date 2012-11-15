moveEditor = ->
	w = $('#my-collections-editor')
	s = $('.sidebar', '#main')
	if w.length is 1 and s.length is 1
		s.append w

bindEditor = ->
	forms =
		editF: $('#my-collections-form')
		newF: $('#my-collections-form-new')
	forms.both = forms.editF.add(forms.newF)
	wrap = $('#my-collections-toggles')
	wrap.on 'click', 'a', (e) ->
		e.preventDefault()
		t = $(this)
		if t.hasClass('current')
			wrap.find('a').removeClass('current')
		else
			wrap.find('a').removeClass('current')
			t.addClass('current')

		if t.is('#my-collections-edit')
			forms.newF.removeClass('in')
			forms.editF.toggleClass('in')
		else
			forms.editF.removeClass('in')
			forms.newF.toggleClass('in')

$ ->
	moveEditor()
	bindEditor()