<?php
/* ----------------------------------------------------------------------
 * app/plugins/simpleGallery/set_info_html.php : 
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
 
$t_set 				= $this->getVar('t_set');
$va_items 		= $this->getVar('items');
$size_types 		= $this->getVar('size_types');
$periodizations 		= $this->getVar('periodizations');
$object_texts 		= $this->getVar('object_texts');
$collections 		= $this->getVar('collections');
$set_id = $t_set->get('set_id');
$va_set_list 		= $this->getVar('sets');
$va_set_images 		= $this->getVar('set_images');
$va_set_descriptions 		= $this->getVar('set_descriptions');
$va_first_items_from_sets 	= $this->getVar('first_items_from_sets');

// print '<pre>'; var_dump($object_ids); print '</pre>';
// print '<pre>'; var_dump($periodizations); print '</pre>';
// print '<pre>'; var_dump(($va_items)); print '</pre>';
// print '<pre>'; var_dump(current($va_items)); print '</pre>';

$sizes = array(
	'Large' => 'large',
	'Velký' => 'large',
	'Velké' => 'large',
	'Middle' => 'mediumlarge',
	'Střední' => 'mediumlarge',
	'Small' => 'small',
	'Malý' => 'small',
	'Malé' => 'small',
);
function sizeClass($size, $sizes) {
	if (isset($sizes[$size])) return $sizes[$size];
	return 'small';
}

?>
<div id="gallerySetDetail">
<?php
# --- selected set info - descriptiona dn grid of items with links to open panel with more info
?>
	<div id="top">
		<div class="img">
			<?php
				$item = $t_set->get('exhibition_cover_large', array('version' => 'mediumlarge'));
				$item = preg_replace('/,\s*/', '', $item); // strip strange dot
				print $item;
			?>
			<b class="ribbon"><?php print _t('On-line exhibition'); ?></b>
		</div>
		<div class="text">
			<h1><?php print $this->getvar('set_title'); ?></h1>
			<div class="description">
				<?php
					$vs_set_description = $this->getVar('set_description');
					print $vs_set_description;
				?>
			</div>
			<?php
				if ($collections && sizeof($collections)) {
			?>
				<div class="related-collections">
					<ul>
						<?php
							foreach ($collections as $id => $name) {
								$link = caNavLink($this->request, _t('Browse complete collection').': '.$name.'<span class="arrow-right"></span>', 'ribbon-link white with-arrow', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'collection_facet', 'id' => $id));
								print '<li>'.$link.'</li>';
							}
						?>
					</ul>
				</div>
			<?php
				}
			?>
		</div>
	</div>
<?php
	print "<div id='setItemsGrid'><ul>";
	$li = array();
	foreach($va_items as $va_item) {
		$class = sizeClass($va_item['ca_attribute_exhibition_size'], $sizes);
		$object_id = $va_item['row_id'];
		$year = false;
		if (isset($periodizations[$object_id])) $year = dateYear($periodizations[$object_id][0]);
		$text = false;
		if (isset($object_texts[$object_id])) {
			# we have a text - let's insert it
			$text = $object_texts[$object_id][0];
			$length = strlen($text);
			$text = substr($text, 0, 200);
			if ($length > 200) $text = $text.'...';
			$link = caNavLink($this->request, _t('more'), '', 'Detail', 'Object', 'Show', array('object_id' =>  $object_id));
			$link = preg_replace('/(object_id\/\d+)/', '\1#text', $link);
			// print '<li class="setItem textItem '.$class.'" id="text-item'.$va_item['item_id'].'">'.$text.'</li>';
			$li[] = '<li class="setItem textItem large visible" id="text-item'.$va_item['item_id'].'"><div class="textContent">&ldquo;'.$text.' ('.$link.')&rdquo;</div></li>';
		} // endif $text
		$item = '';
		$item .= '<li class="setItem visible '.$class.'" id="item'.$va_item['item_id'].'">';
			$item .= '<div class="img">';
				$item .= caNavLink($this->request, ratioImg(lazyLoadImg($va_item['representation_tag_'.$class])), '', 'Detail', 'Object', 'Show', array('object_id' =>  $object_id));
			$item .= '</div>';
			$item .= '<div class="text">';
				$item .= '<h2 class="h2">';
					$item .= $va_item['name'];
					if ($year) {
						$item .= ', ';
						$item .= caNavLink($this->request, $year['text'], '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'periodization_facet', 'id' => $year['search']));
					}
				$item .= '</h2>';
				if ($va_item['set_item_label'] !== '[BLANK]') $item .= '<p>'.$va_item['set_item_label'].'</p>';
				$item .= '<div class="more">'.caNavLink($this->request, _t('detail'), '', 'Detail', 'Object', 'Show', array('object_id' =>  $object_id)).'</div>';
			$item .= '</div>';
		$item .= '</li>';
		$li[] = $item;
	}
	print join('', $li);
	print "</ul></div><!-- end setItemsGrid -->";
?>
			<?php
				if ($collections && sizeof($collections)) {
			?>
				<div class="related-collections">
					<ul>
						<?php
							foreach ($collections as $id => $name) {
								$link = caNavLink($this->request, _t('Browse complete collection').': '.$name.'<span class="arrow-right"></span>', 'ribbon-link white with-arrow', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'collection_facet', 'id' => $id));
								print '<li>'.$link.'</li>';
							}
						?>
					</ul>
				</div>
			<?php
				}
			?>
</div><!-- end gallerySetDetail -->
<?php
	unset($va_set_list[$set_id]);
	if(sizeof($va_set_list) > 0){
?>
	<div id="more-online-collections">
	<?php
	print '<ul class="count-'.count($va_set_list).'">';
	foreach ($va_set_list as $vn_set_id => $va_set_info) {
		$img = (isset($va_set_images[$vn_set_id])) ? $va_set_images[$vn_set_id][0] : '';
		$img = caNavLink($this->request, $img, '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id));
		$desc = (isset($va_set_descriptions[$vn_set_id])) ? nl2br(shorten($va_set_descriptions[$vn_set_id][0], 130)) : '';
		print '<li>';
			print '<div class="img">'.$img.'</div>';
			print '<div class="text">';
				print '<h3>'.caNavLink($this->request, shorten($va_set_info["name"], 35), '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id)).'</h3>';
				print '<div class="description">';
					print $desc;
				print '</div>';
				print '<div class="more">'.caNavLink($this->request, _t('detail'), '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id)).'</div>';
			print '</div>';
		print '</li>';
	}
	print '</ul>';
	print caNavLink($this->request, _t('More on-line exhibitions'), 'more-link', 'simpleGallery', 'Show', 'Index');
	?>
	</div><!-- end more-online-collections -->
<?php
	}
?>