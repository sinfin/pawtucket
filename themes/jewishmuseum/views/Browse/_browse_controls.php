<?php
	$va_facets = $this->getVar('available_facets');
	$va_facet_info = $this->getVar('facet_info');
	$va_criteria = $this->getVar('criteria');
	$fi = $va_facet_info;
	$url = caNavUrl($this->request, '', 'Search', 'Facets');
	$controller = $this->request->getController();
	$is_search = $controller == 'Search';
?>
<div id="browseControls" data-facets-url="<?php print $url; ?>" data-controller="<?php print $controller; ?>">
	<div id="refineBrowse">
	<?php
		print "<ul>";
		if (sizeof($va_facets)) { 
			$vn_i = 1;
			$va_available_facets = $this->getVar('available_facets');
			if (count($va_available_facets) > 0) {
				foreach($va_available_facets as $vs_facet_code => $va_facet_info) {
					print "<li><a href='#{$vs_facet_code}' data-facet='{$vs_facet_code}' class='facetLink'>".ucfirst(_t($va_facet_info['label_plural']))."<span class=\"ico-triangle\"></span></a></li>";
				}
			}
		}
		if (sizeof($va_criteria)) { 
			foreach($va_criteria as $vs_facet_name => $va_row_ids) {
				print "<li><span class='facetLink'>".ucfirst(_t($fi[$vs_facet_name]['label_plural']))."</span>";
				foreach($va_row_ids as $vn_row_id => $vs_label) {
					if ($is_search) {
						print '<span class="item">'.caNavLink($this->request, '', 'ico-close', '', 'Search', 'removeCriteria', array('facet' => $vs_facet_name, 'id' => $vn_row_id)).$vs_label.'</span>';
					} else {
						print '<span class="item">'.caNavLink($this->request, '', 'ico-close', '', 'Browse', 'removeCriteria', array('facet' => $vs_facet_name, 'id' => $vn_row_id)).$vs_label.'</span>';
					}
				}
				print "</li>";
			}						
		}
		print "</ul>";
	?>
	</div><!-- end refineBrowse -->
<?php
	print '<div class="start-over">'.caNavLink($this->request, "<span class=\"ico-close\"></span>"._t('Start new search'), 'startOver', '', 'Browse', 'clearCriteria', array()).'</div>';
?>
</div><!-- end browseControls -->