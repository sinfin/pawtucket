<div class="item-nav">
<?php
if (isset($t_object)) {
	// $idno_siblings = $this->getVar('idno_siblings');
	// print caNavLink($this->request, _t('Back to the results').'<span class="ico"></span>', '', 'Search', 'Index', '', array(), array('class' => 'nav-results'));
	// object
	print '<div class="item-nav-left">';
		if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t("back to the results"), ''))) {
			print $vs_back_link;
			if ($this->getVar('previous_id')) {
				print caNavLink($this->request, _t('previous'), 'fullscreen-target', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')));
			}
			if ($this->getVar('next_id') > 0) {
				print caNavLink($this->request, _t('next'), 'fullscreen-target', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')));
			}
		} else {
			$vs_back_link = caNavLink($this->request, _t('browse for more').'<span class="ico"></span>', '', 'Browse', 'Index', '', array());
			print $vs_back_link;
		}
	print '</div>';
	print '<div class="item-nav-idno">';
		if ($idno_siblings['prev_id']) {
			print caNavLink($this->request, '', 'fullscreen-target arrow', 'Detail', 'Object', 'Show', array('object_id' => $idno_siblings['prev_id']), array('class' => 'arrow previous'));
		}
		$class = 'with-tree';
		$tree = hieararchyTree($collection_tree, $this->request);
		if (empty($tree)) $class = 'without-tree';
		print '<div class="idno-wrap '.$class.'"><small class="toggle"><span class="icon-item-nav"><span></span></span>' . $t_object->get('idno') . '</small>' . $tree . '</div>';
		if ($idno_siblings['next_id']) {
			print caNavLink($this->request, '', 'fullscreen-target arrow next', 'Detail', 'Object', 'Show', array('object_id' => $idno_siblings['next_id']), array('class' => 'arrow next'));
		}
	print '</div>';
	
} elseif (isset($t_collection)) {
	// collection
	// var_dump($t_collection->getHierarchyChildren());
	$ancestors = $t_collection->getHierarchyAncestors();
	$str = '';
	foreach ($ancestors as $v) {
		$str .= caNavLink($this->request, $v['NODE']['idno'], '', '', 'Browse', 'addCriteria', array('facet' => 'collection_facet', 'id' => $v['NODE']['collection_id'])) . ' / ';
	}
	print "<small>" . $str . $t_collection->get('idno') . "</small>";
}
?>
</div>