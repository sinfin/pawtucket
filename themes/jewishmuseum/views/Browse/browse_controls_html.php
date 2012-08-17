<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_objects_browse_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2011 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
	$va_facets 				= $this->getVar('available_facets');
	$va_facets_with_content	= $this->getVar('facets_with_content');
	$va_facet_info 			= $this->getVar('facet_info');
	$va_criteria 			= is_array($this->getVar('criteria')) ? $this->getVar('criteria') : array();
	$va_results 			= $this->getVar('result');
	
	$vs_browse_target		= $this->getVar('target');
	
	$fi = $va_facet_info;
	
	if (!$this->request->isAjax()) {
		if ($this->getVar('browse_selector')) {
	?>
			<div class="browseTargetSelect"><?php print _t('Browse for').' '.$this->getVar('browse_selector'); ?></div>
	<?php
		}
?>
	<div id="browse"><div id="resultBox"> 
<?php
	}
	print $this->render('Browse/_browse_controls.php');
	
	if (sizeof($va_criteria) > 0) {
		if ($this->getVar('current_view') !== 'map') print $this->render('Results/paging_controls_html.php');

		print $this->render('Search/search_controls_html.php');

		print "<div class='sectionBox'>";

		$vs_view = $this->getVar('current_view');

		if(in_array($vs_view, array_keys($this->getVar('result_views')))){
			print $this->render('Results/'.$vs_browse_target.'_results_'.$vs_view.'_html.php');
		}

		print "</div>";

		# --- show results
		print $this->render('Results/paging_controls_html.php');
	} else {
		print $this->render('Browse/browse_intro_text_html.php');
	}
?>
	</div><!-- end resultbox --></div><!-- end browse -->

<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
	<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton">&nbsp;</a>
	<div id="splashBrowsePanelContent">
	
	</div>
</div>
<?php
	if (!$this->request->isAjax()) {
?>
<script type="text/javascript">
	var caUIBrowsePanel = caUI.initBrowsePanel({ 
		facetUrl: '<?php print caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'getFacet'); ?>',
		addCriteriaUrl: '<?php print caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'addCriteria'); ?>',
		singleFacetValues: <?php print json_encode($this->getVar('single_facet_values')); ?>
	});
</script>
<?php
	}
?>