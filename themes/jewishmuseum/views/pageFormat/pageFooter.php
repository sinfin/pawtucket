		</div><!-- end .content -->
	</div><!-- end #main -->
	<div id="push"></div>
	<?php
		print TooltipManager::getLoadHTML();
	?>

</div>
<div id="footer"><div class="inner">
	<ul class="footer-left">
		<li><?php print caNavLink($this->request, _t("Contribute to the collections"), "ribbon-link", "", "Splash", "Contribute"); ?></li>
		<li><a href="fotoarchiv/jewishmuseum.cz" class="em custom-text ribbon-link" data-em="fotoarchiv/jewishmuseum.cz"><?php print _t('If you wish to obtain digital copies of JMP images, contact us at').' fotoarchiv@jewishmuseum.cz'; ?></a></li>
	</ul>
	<ul class="footer-links">
		<!-- <li><a href="#">Lorem ipsum dolor</a></li>
		<li><a href="#">Sit amet consectetur</a></li>
		<li><a href="#">Adipiscing elit</a></li>
		<li><a href="#">Nullam nec lacus</a></li>
		<li><a href="#">At mauris</a></li>
		<li class="copyright"><?php print "&copy; " . date('Y') . ' ' ._t('Židovské muzeum v Praze'); ?></li> -->
		<li class="copyright"><?php print "&copy; " . date('Y') . ' ' ._t('Židovské muzeum v Praze'); ?></li>
	</ul>
	<!-- 
	<div class="footer-newsletter">
		<label for="newsletter"><?php print _t('Sign in for newsletter') . ':'; ?></label>
		<div class="input">
			<input type="text" id="newsletter" placeholder="e-mail" size="30" />
		</div>
	</div> -->
	<div class="footer-share">
		<a href="http://cs-cz.facebook.com/pages/Židovské-muzeum-v-Praze-The-Jewish-Museum-in-Prague/292572604355" target="_blank" class="ico"></a>
		<?php
			print caNavLink($this->request, '', '', 'Feed', 'recentlyAdded', '', '', array('class' => 'ico rss', 'target' => '_blank'));
		?>
	</div>
	<?php // print $this->request->config->get('page_footer_text'); ?> 
	<!-- [<?php print $this->request->session->elapsedTime(4).'s'; ?>/<?php print caGetMemoryUsage(); ?>] -->
</div></div><!-- end footer -->

	<div id="caMediaPanel"> 
		<div id="close"><a href="#" onclick="caMediaPanel.hidePanel(); return false;">&nbsp;&nbsp;&nbsp;</a></div>
		<div id="caMediaPanelContentArea">
		
		</div>
	</div>

	
	<script type="text/javascript">
	/*
		Set up the "caMediaPanel" panel that will be triggered by links in object detail
		Note that the actual <div>'s implementing the panel are located here in views/pageFormat/pageFooter.php
	*/
	var caMediaPanel;
	jQuery(document).ready(function() {
		if (caUI.initPanel) {
			caMediaPanel = caUI.initPanel({ 
				panelID: 'caMediaPanel',										/* DOM ID of the <div> enclosing the panel */
				panelContentID: 'caMediaPanelContentArea',		/* DOM ID of the content area <div> in the panel */
				exposeBackgroundColor: '#000000',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
				exposeBackgroundOpacity: 0,							/* opacity of background color masking out page content; 1.0 is opaque */
				panelTransitionSpeed: 200, 									/* time it takes the panel to fade in/out in milliseconds */
				allowMobileSafariZooming: true,
				mobileSafariViewportTagID: '_msafari_viewport'
			});
		}
	});
	</script>
</body>
</html>
