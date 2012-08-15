<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_objects_search_html.php 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
 
	$vo_result 				= $this->getVar('result');
	$vo_result_context 		= $this->getVar('result_context');

	$o_browse = $this->getVar('browse');
	
	$va_available_facets = $o_browse->getInfoForAvailableFacets();
	$va_facet_info = $o_browse->getInfoForFacets();
	$this->setVar('facet_info', $va_facet_info);
		
	// if (sizeof($va_available_facets)) {// if we can refine, refine!
		$this->setVar('available_facets', $va_available_facets);
	// }
	
	$va_criteria = $o_browse->getCriteriaWithLabels();
	// if(sizeof($va_criteria) > 1){
		$this->setVar('criteria', $va_criteria);
	// }

 ?>
 	<div id="resultBox">
<?php
	if($vo_result) {

		if ($this->getVar('current_view') !== 'map') print $this->render('Results/paging_controls_html.php');
		print $this->render('Search/search_controls_html.php');
		print $this->render('Browse/_browse_controls.php');
?>
	<div class="sectionBox">
<?php
		$vs_view = $vo_result_context->getCurrentView();
		if ((!$vs_view) || ($vo_result->numHits() == 0) || (!in_array($vs_view, array_keys($this->getVar('result_views'))))) {
			print $this->render('Results/ca_objects_search_no_results_html.php');
		}else{
			print $this->render('Results/ca_objects_results_'.$vs_view.'_html.php');
		}
		print $this->render('Results/ca_objects_search_secondary_results.php');
?>		
	</div><!-- end sectionbox -->
<?php
		print $this->render('Results/paging_controls_html.php');
	}
?>
<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
	<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton">&nbsp;</a>
	<div id="splashBrowsePanelContent">
	
	</div>
</div>
<?php
	$va_single_facet_values = array();
	foreach($va_facet_info as $vs_facet => $va_facet_settings) {
		$va_single_facet_values[$vs_facet] = isset($va_facet_settings['single_value']) ? $va_facet_settings['single_value'] : null;
	}
?>
<script type="text/javascript">
	var caUIBrowsePanel = caUI.initBrowsePanel({ 
		facetUrl: '<?php print caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'getFacet'); ?>',
		addCriteriaUrl: '<?php print caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'addCriteria'); ?>',
		singleFacetValues: <?php print json_encode($va_single_facet_values); ?>
	});
</script>
	</div><!-- end resultbox -->