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
 
$va_ids 						= $this->getVar('ids');		// this is a search result row
$va_access_values 		= $this->getVar('access_values');
$va_label					= $this->getVar('label');
$this->setVar('noLi', true);

if (strlen($va_label) > 1) {
	print '<h2 class="mapBalloon-place-label">'.$va_label.'</h2>';
}
print '<div class="mapBalloons">';
foreach ($va_ids as $object_id) {
?>
	<div class="mapBalloon">
		<?php
			$t_object = new ca_objects($object_id);
			$this->setVar('object', $t_object);
			
			print $this->render('Results/_ca_objects_result_item.php');
		?>
	</div>
<?php
}
print '</div>';
?>