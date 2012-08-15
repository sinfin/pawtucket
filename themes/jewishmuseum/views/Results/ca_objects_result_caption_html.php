<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/ca_objects_result_caption_html.php :
 * 		thumbnail search results
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
?>
<?php
	$t_item = $this->getVar('object');
	$id = $t_item->get('object_id');
	$img = $t_item->getPrimaryRepresentation(array('thumbnail'), array('thumbnail'), array('checkAccess' => $va_access_values));
	$img = lazyLoadImg($img['tags']['thumbnail']);
	print '<div class="img">' . caNavLink($this->request, $img, '', 'Detail', 'Object', 'Show', array('object_id' => $id)) . '</div>';
?>
<div class="text">
<?php
	$print_this = "";
	$type = caNavLink($this->request, $t_item->getTypeName(), '', '', 'Browse', 'addCriteria', array('facet' => 'type_facet', 'id' => $t_item->get('type_id')));
	$year = dateYear($t_item->get('periodization'));
	$year = caNavLink($this->request, $year['text'], '', '', 'Browse', 'addCriteria', array('facet' => 'periodization_facet', 'id' => $year['search']));
	$title = strlen(trim($this->getVar('label'))) > 0 ? $this->getVar('label') : $t_item->get('name');

	$print_this .= "<h2>{$title}</h2>";
	$print_this .= '<div class="date">'.$year.'</div>';
	$print_this .= '<div class="type">'.$type.'</div>';
	$print_this .= '<div class="more">';
		$print_this .= caNavLink($this->request, _t('detail'), '', 'Detail', 'Object', 'Show', array('object_id' => $id));
	$print_this .= '</div>';
	
	print $print_this;
?>
</div>