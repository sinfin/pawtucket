carouselAdapt = -> 
	ow = $(window).width()
	tw = ow - 330 - 300 - 20
	tw = 620 if (tw > 620)
	window.carouselImages.width tw

carouselAdaptive = -> 
	carouselAdapt()
	$(window).bind('resize', carouselAdapt())

initCarousel = -> 
	wrap = $('ul', '#home-featured');
	return false unless wrap.length is 1
	hf = $('#home-featured')
	height = wrap.find('.img').width()
	settings =
		width: hf.width()
		height: height
		responsive: true
		pagination:
			container: '#home-featured-pagination'
		scroll:
			fx: 'crossfade'
			pauseOnHover: true
		auto:
			play: true
			# play: false
			pauseDuration: 4000
		items:
			visible: 1
			width: wrap.width()
	wrap.carouFredSel(settings)
	
	$(window).on 'resize load', ->
		set =
			items:
				width: hf.width()
			height: wrap.find('.img').width()
			width: hf.width()
		wrap.trigger 'configuration', set

initDarkScroll = ->
	wrap = $('ul', '#home-dark');
	return false unless wrap.length is 1
	return false unless wrap.find('li').length < 3
	settings =
		width: '100%'
		infinite: false
		circural: false
		align: 'left'
		# responsive: true
		padding: [0, 20, 0, 20]
		scroll:
			items: 2
		prev:
			button: '#home-dark-left'
		next:
			button: '#home-dark-right'
		auto:
			play: false
		items:
			width: 380
		
	wrap.carouFredSel(settings)	
	
$ ->
	window.carouselImages = $('.img', '#home-featured')
	
#	carouselAdaptive()
	initCarousel()
	initDarkScroll()