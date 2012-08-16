<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/ca_objects_results_map_balloon_html.php :
 * 		full search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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
 
$qr_data 						= $this->getVar('data');		// this is a search result row
$va_access_values 		= $this->getVar('access_values');

$object_id = $qr_data->get("ca_objects.object_id");

$year = dateYear($qr_data->get('ca_objects.periodization'));
$vs_media_tag = $qr_data->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values));
?>
<div class="mapBalloon">
	<div class="img">
		<?php
			if ($vs_media_tag) {
				print caNavLink($this->request, $vs_media_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $object_id));
			}
		?>
	</div>
	<div class="text">
		<?php
			$title = caNavLink($this->request, $qr_data->get("ca_objects.preferred_labels"), 'fullscreen-target', 'Detail', 'Object', 'Show', array('object_id' => $id));
			if ($year) {
				$year = caNavLink($this->request, $year['text'], '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'periodization_facet', 'id' => $year['search']));
			}
			print '<h2>'.$title.'</h2>';
			print '<div class="date">'.$year.'</div>';
			print '<div class="more">';
				print caNavLink($this->request, _t('detail'), 'fullscreen-target', 'Detail', 'Object', 'Show', array('object_id' => $object_id));
			print '</div>';
		?>
	</div>
</div><!-- end mapBallon -->