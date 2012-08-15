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
		$class = $this->getVar('number') ? 'item-'.$this->getVar('number') : 'item-no-number';
		$ajax = $this->getVar('ajax') ? $this->getVar('ajax') : false;
		$id = $t_item->get('object_id');
		$noLi = strlen($this->getVar('noLi')) > 0 ? $this->getVar('noLi') : false;
		$img = $t_item->getPrimaryRepresentation(array('thumbnail', 'thumbnail140'), array('thumbnail', 'thumbnail140'), array('checkAccess' => $va_access_values));
		// if ($ajax) {
			$img = $img['tags']['thumbnail'];
		// } else {
			// $img = lazyLoadImg($img['tags']['thumbnail']);
		// }
	?>
<?php
if (!$noLi) print '<li class="'.$class.'">';
	print '<div class="img">' . caNavLink($this->request, $img, '', 'Detail', 'Object', 'Show', array('object_id' => $id)) . '</div>';
	print '<div class="text">';
		$print_this = "";
		$type = caNavLink($this->request, $t_item->getTypeName(), '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'type_facet', 'id' => $t_item->get('type_id')));
		$year = dateYear($t_item->get('periodization'));
		if ($year) {
			$year = caNavLink($this->request, $year['text'], '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'periodization_facet', 'id' => $year['search']));
		}
		if (strlen(trim($this->getVar('item_label'))) > 0) {
			$title = $this->getVar('item_label');
		} else {
			$title = shorten($t_item->getLabelForDisplay());
		}
		$title = caNavLink($this->request, $title, 'fullscreen-target', 'Detail', 'Object', 'Show', array('object_id' => $id));

		$print_this .= "<h2>{$title}</h2>";
		if ($year) {
			$print_this .= '<div class="date">'.$year.'</div>';
		}
		$print_this .= '<div class="type">'.$type.'</div>';
		$print_this .= '<div class="more">';
			$print_this .= caNavLink($this->request, _t('detail'), 'fullscreen-target', 'Detail', 'Object', 'Show', array('object_id' => $id));
		$print_this .= '</div>';
		
		print $print_this;
	print '</div>';
if (!$noLi) print '</li>';
?>