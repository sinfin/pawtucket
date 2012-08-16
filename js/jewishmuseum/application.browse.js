// Generated by CoffeeScript 1.3.3
(function() {
  var bindFacetLinks, displayOptions, initPagination, moveControls;

  moveControls = function() {
    var c;
    c = $('#browseControls');
    if (c.length === 1) {
      return $('.browse', '#navigation').addClass('active').append(c);
    }
  };

  displayOptions = function() {
    $('#main .content').on('click', '#display-options a', function(e) {
      var t;
      e.preventDefault();
      t = $(this);
      t.siblings('input').attr('checked', 'checked');
      return t.parents('form').submit();
    });
    return $('#main .content').on('click', '#searchOptionsBox .order', function(e) {
      var h;
      e.preventDefault();
      h = $(this).attr('href').split('#');
      return $('#direction-select').val(h[1]).parents('form').submit();
    });
  };

  window.initSlider = function(slider, items) {
    var count, handle, settings;
    count = items.length - 1;
    settings = {
      max: count
    };
    slider.slider(settings);
    items.slice(10, count).hide(0);
    slider.find('.ui-slider-handle').append('<span class="handle-text"><span id="handle-text-year">' + items.first().find('.browseSelectPanelLink').text() + '</span></span>');
    handle = $('#handle-text-year');
    $('#browsePanelSearch').hide(0);
    return slider.on('slide', function() {
      var sh, v;
      v = slider.slider('value');
      handle.text(items.eq(v - 1).find('.browseSelectPanelLink').text());
      if (v < 6) {
        v = 6;
      }
      if ((v + 5) > count) {
        v = count;
      }
      sh = items.slice(v - 6, v + 5);
      sh.show(0);
      return items.not(sh).hide(0);
    });
  };

  initPagination = function() {
    return $('#main').on('click', '.pagination .pagination-link', function(e) {
      var rb, t, url, v;
      e.preventDefault();
      t = $(this);
      url = t.data('url');
      if (typeof url === 'undefined') {
        return false;
      }
      rb = $('#resultBox');
      if (rb.hasClass('loading')) {
        return false;
      }
      if (t.hasClass('from-input')) {
        v = t.siblings('#jumpToPageNum').val();
        if (!(v.length > 0)) {
          return false;
        }
        url = url + parseInt(v);
      }
      rb.addClass('loading').load(url, function() {
        rb.removeClass('loading');
        rb.find('#resultBox').unwrap();
        return window.equalHeight($('.grid > ul', '#resultBox'));
      });
      return false;
    });
  };

  bindFacetLinks = function() {
    return $('body').on('click', '.facetLink', function(e) {
      var facet;
      e.preventDefault();
      e.stopPropagation();
      facet = $(this).data('facet');
      if (typeof facet !== 'undefined') {
        return caUIBrowsePanel.showBrowsePanel(facet);
      }
    });
  };

  $(function() {
    moveControls();
    displayOptions();
    initPagination();
    return bindFacetLinks();
  });

}).call(this);