<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/ca_objects_results_full_html.php :
 * 		full search results
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
 
 	
$vo_result 					= $this->getVar('result');
$vn_items_per_page 	= $this->getVar('current_items_per_page');
$va_access_values 		= $this->getVar('access_values');
// print '<pre>'; var_dump(get_class($vo_result)); print '</pre>';
if($vo_result) {
	print '<table class="browse-result">';
		$vn_item_count = 0;
		
		while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
			$t_object = new ca_objects($vo_result->get('object_id'));
			$vn_object_id = $vo_result->get('object_id');
			$va_labels = $vo_result->getDisplayLabels();
			
			// $attr = $this->request->config->get('ca_objects_map_attribute');
			// print '<pre>'; var_dump($vo_result); print '</pre>';
			// print '<pre>'; var_dump($vo_result->get('ca_objects.georeference')); print '</pre>';
			// print '<pre>'; var_dump($t_object->get('object_id')); print '</pre>';
			// print '<pre>'; var_dump($t_object->get($attr)); print '</pre>';

			$vs_caption = "";
			foreach($va_labels as $vs_label){
				$vs_caption .= $vs_label;
			}
			
			$year = dateYear($t_object->get('periodization'));
			if ($year) $year = caNavLink($this->request, $year['text'], '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'periodization_facet', 'id' => $year['search']));
			$type = caNavLink($this->request, $t_object->getTypeName(), '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'type_facet', 'id' => $t_object->get('type_id')));
			$idno = $t_object->get('idno');
			$link = caNavLink($this->request, _t('detail'), '', 'Detail', 'Object', 'Show', array('object_id' => $t_object->get('object_id')));
			
			print "<tr>
				<td class=\"title\"><h2>{$vs_caption}</h2></td>
				<td class=\"year\">{$year}</td>
				<td class=\"type\">{$type}</td>
				<td class=\"idno\">{$idno}</td>
				<td class=\"link\">{$link}</td>
			</tr>";
			
			$vn_item_count++;
		}		
		print "</table>";
	}
?>