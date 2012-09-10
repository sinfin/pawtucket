<!DOCTYPE html>
<?php
	$locale = caGetUserLocaleRules();
	$locale = array_keys($locale['preferred']);
	$locale = $locale[0];
	$htmlLocale = substr($locale, 0, 2);
?>
<!--[if lt IE 7 ]> <html lang="<?php print $htmlLocale ?>" dir="ltr" class="ie6 ie lang-<?php print $htmlLocale ?>"> <![endif]-->
<!--[if IE 7 ]> <html lang="<?php print $htmlLocale ?>" dir="ltr" class="ie7 ie lang-<?php print $htmlLocale ?>"> <![endif]-->
<!--[if IE 8 ]> <html lang="<?php print $htmlLocale ?>" dir="ltr" class="ie8 ie lang-<?php print $htmlLocale ?>"> <![endif]-->
<!--[if IE 9 ]> <html lang="<?php print $htmlLocale ?>" dir="ltr" class="ie9 lang-<?php print $htmlLocale ?>"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="<?php print $htmlLocale ?>" class="non-ie lang-<?php print $htmlLocale ?>" dir="ltr"> <!--<![endif]-->
<head>
	<title><?php print _t($this->request->config->get('html_page_title')); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="alternate" type="application/rss+xml" title="<?php print _t("Collections' catalogue").', RSS'; ?>" href="<?php print $this->request->getBaseUrlPath(); ?>/index.php/Feed/recentlyAdded" />
	<?php print MetaTagManager::getHTML(); ?>
	
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" media="all" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/print.css" rel="stylesheet" media="print" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jqueryasffas/jquery-jplayer/jplayer.blue.monday.css" type="text/css" media="screen" />
	<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getThemeUrlPath(true); ?>/css/iestyles.css" />
	<![endif]-->
	<script type="text/javascript">
		window.baseUrl = '<?php print $this->request->getBaseUrlPath(); ?>';
	</script>
<?php
	print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
</head>
<body<?php print " class=\"" . $this->request->getController() . ' ' . $this->request->getAction() . "\""; ?>>
<div id="page-wrap">
	<div id="header">
		<div class="inner">
			<div class="cs" id="logo">
				<?php
					// logo link
					$filename = 'logo-JMP-en';
					if ($htmlLocale == 'cs') $filename = 'logo-ZMP';
					if ($this->request->getAction() == 'displaySet') {
						$filename = 'logo-JMP-small-white-en';
						if ($htmlLocale == 'cs') $filename = 'logo-ZMP-small-white';
					}
					$img = '<img src="'.$img = $this->request->getThemeUrlPath(true).'/graphics/'.$filename.'.png" alt="'._t("Collections' catalogue").'" />';
					print caNavLink($this->request, $img, $locale, "", "", "");
				?>
			</div>
			<div class="cm">
				<ul id="main-menu">
				<?php
					if ($this->request->getAction() == 'displaySet') {
					?>
					<li><?php print caNavLink($this->request, _t("Back to collections"), "", "", "Browse", "clearCriteria", ""); ?></li>
					<?php
					} else {
					?>
					<li><a href="<?php
						print ($locale == 'cs') ? 'http://www.jewishmuseum.cz/czindex.php' : 'http://www.jewishmuseum.cz/aindex.php';
					?>"><?php print _t('JMP web-site') ?></a></li>
					<!-- <li class="current"><a href="#">Sbírky</a></li> -->
					<?php
					}
					?>
				</ul>
			</div>
			<?php
				if ($this->request->getAction() == 'displaySet') {
			?>
			<div id="online-exhibition-search">
				<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" placeholder="<?php print _t('Search in this exhibition'); ?>" />
				<div class="submit"></div>
				<span class="results-count">
					<?php
						print _t('Found').' <span class="count"></span> '._t('results.');
					?>
				</span>
			</div>
			<?php
				}
			?>
			<div id="header-box">
				<ul>
				<?php
					# Locale selection
					global $g_ui_locale;
					$vs_base_url = $this->request->getRequestUrl();
					$vs_base_url = ((substr($vs_base_url, 0, 1) == '/') ? $vs_base_url : '/'.$vs_base_url);
					$vs_base_url = str_replace("/lang/[A-Za-z_]+", "", $vs_base_url);
					
					if (is_array($va_ui_locales = $this->request->config->getList('ui_locales')) && (sizeof($va_ui_locales) > 1)) {
						// print caFormTag($this->request, $this->request->getAction(), 'caLocaleSelectorForm', null, 'get', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true));
					
						// $va_locale_options = array();
						sort($va_ui_locales);
						foreach($va_ui_locales as $vs_locale) {
							$va_parts = explode('_', $vs_locale);
							$vs_lang_name = Zend_Locale::getTranslation(strtolower($va_parts[0]), 'language', strtolower($va_parts[0]));
							// $va_locale_options[$vs_lang_name] = $vs_locale;
							// $url = caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array('lang' => $vs_locale));
							// $url = getCurrentURL();
							$url = caNavUrl($this->request, '', 'Splash', 'Index', array('lang' => $vs_locale));
							// $url = preg_replace('/\/lang\/.*/', '', $url);
							// $url = preg_replace('/$\//', '', $url);
							// $url = $url.'/lang/'.$vs_locale;

							$name = $va_parts[1] == 'US' ? 'EN' : $va_parts[1];
							print "<li><a href=\"{$url}\" title=\"{$vs_lang_name}\">{$name}</a></li>";
						}
						// print caHTMLSelect('lang', $va_locale_options, array('id' => 'caLocaleSelectorSelect', 'onchange' => 'window.location = \''.caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array('lang' => '')).'\' + jQuery(\'#caLocaleSelectorSelect\').val();'), array('value' => $g_ui_locale, 'dontConvertAttributeQuotesToEntities' => true));
						// print "</form>\n";
					
					}
				?>
				<?php
					if (!$this->request->config->get('dont_allow_registration_and_login')) {
						if ($this->request->isLoggedIn()) {
						?>
							<li><?php print caNavLink($this->request, $this->request->user->getName(), "", "", "Sets", "Index"); ?></li>
							<li><?php print caNavLink($this->request, _t("Log out"), "", "", "LoginReg", "logout"); ?></li>
						<?php
						} else {
						?>
							<li><?php print caNavLink($this->request, _t("Log in"), "", "", "LoginReg", "form"); ?></li>
						<?php
						}
					} // endif			
				?>
					<li class="print">
						<span class="print-page ico-print" data-notification="<?php print _t('Preparing document, loading images. This may take a while...'); ?>"></span>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div id="main"><?php // ends in pageFooter.php ?>
		<div class="sidebar">
			<div id="navigation">
				<ul class="menu">
				<?php
					$controller = $this->request->getController();
					$action = $this->request->getAction();
				?>	
					<li<?php print ($controller == 'Splash' && $action == 'Index') ? ' class="current"' : ''; ?>><?php print caNavLink($this->request, _t("Collections' catalogue"), "", "", "", ""); ?></li>
					<li<?php print ($controller == 'Show') ? ' class="current"' : ''; ?>><?php print caNavLink($this->request, _t("On-line exhibitions"), "", "simpleGallery", "Show", "Index"); ?></li>
					<!-- <li><?php print caNavLink($this->request, _t("Collections hierarchy"), "", "Hierarchy", "Show", "Index"); ?></li> -->
					<li<?php print ($controller == 'Splash' && $action == 'About') ? ' class="current"' : ''; ?>><?php print caNavLink($this->request, _t("About collections"), "", "", "Splash", "About"); ?></li>
				</ul>
				<div class="browse">
					<?php
						$class = 'browse-link';
						if ($controller == 'Browse') $class .= ' current';
						print caNavLink($this->request, _t("Browse collections") . '<span class="arrow"></span>', "", "", "Browse", "clearCriteria", "", array('class' => $class));
					?>
					<div id="search">
						<?php
							// get last search ('basic_search' is the find type used by the SearchController)
							$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
							$vs_search = $o_result_context->getSearchExpression();
						?>
						<form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
							<input type="text" name="search" value="" placeholder="<?php print _t('Search in collections'); ?>" id="quickSearch" />
							<div class="submit"><input type="submit" value="s" /></div>
						</form>
					</div>
					<?php
						if ($controller == 'Browse' || $controller == 'Search') {
							// require_once($this->request->getViewsDirectoryPath().'/Search/_sidebar_controls_html.php');
						}
					?>
				</div>
			</div>
			<span class="fullscreen-arrow ico-right"></span>
		</div>
		<div class="content"><?php // ends in pageFooter.php ?>
