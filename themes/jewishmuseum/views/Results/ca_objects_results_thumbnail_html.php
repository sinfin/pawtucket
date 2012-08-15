<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/ca_objects_results_thumbnail_html.php :
 * 		thumbnail search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2010 Whirl-i-Gig
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
 
 	
$vo_result = $this->getVar('result');
$vn_items_per_page = $this->getVar('current_items_per_page');
$va_access_values = $this->getVar('access_values');
$this->setVar('ajax', $this->request->isAjax());

if($vo_result) {
	$rand = 'random-'.rand();
	print '<div class="grid search '.$rand.'"><ul>';
		$vn_item_count = 0;
		
		while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
			$t_object = new ca_objects($vo_result->get('object_id'));
			$vn_object_id = $vo_result->get('object_id');
			$va_labels = $vo_result->getDisplayLabels();
			
			$vs_caption = "";
			foreach($va_labels as $vs_label){
				$vs_caption .= $vs_label;
			}
			
			// Get thumbnail caption
			$this->setVar('object', $t_object);
			$this->setVar('item_label', $vs_caption);
			
			print $this->render('Results/_ca_objects_result_item.php');
			
			$vn_item_count++;
		}		
		print "</ul></div>";
	}
?>
