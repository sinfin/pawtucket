<?php
/* ----------------------------------------------------------------------
 * app/plugins/simpleGallery/landing_html.php : 
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
 
	$va_set_list = $this->getVar('sets');
	$va_first_items_from_sets = $this->getVar('first_items_from_sets');
	$va_set_descriptions = $this->getVar('set_descriptions');
	$images = $this->getVar('images');
?>
<h1><?php print _t("On-line collections"); ?></h1>
<div id="galleryLanding">
<!-- 	<div class="textContent">
		<?php
			print $this->render('jewishmuseum/intro_text_html.php');
		?>
	</div> -->
	<ul class="collections-list">
	<?php
		foreach($va_set_list as $vn_set_id => $va_set_info) {
			$img = (isset($images[$vn_set_id])) ? $images[$vn_set_id][0] : '';
			$img = caNavLink($this->request, $img, '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id));
			print '<li>';
				print '<div class="img">'.$img.'</div>';
				print '<div class="text">';
					print '<h2>'.caNavLink($this->request, $va_set_info["name"], '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id)).'</h2>';
					print '<div class="description">';
						print nl2br($va_set_descriptions[$vn_set_id][0]);
					print '</div>';
					print '<div class="more">'.caNavLink($this->request, _t('detail'), '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id)).'</div>';
				print '</div>';
			print '</li>';
		}
	?>
	</ul>
</div>
