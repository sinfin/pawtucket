		<div class="item-type"><?php print $t_object->getTypeName(); ?></div>
		<?php
			# --- Date
			// $date = $t_object->get('periodization/value_longtext1');
			// print '<pre>'; var_dump($date); print '</pre>';
			$date = $t_object->get('periodization');
			if (strlen($date)) {
				$dates = preg_replace('/(\d{4}),/i', '$1|,|', $date);
				$dates = explode('|,|', $dates);
				print '<div class="item-date"><ul>';
					foreach ($dates as $date) {
						print '<li>'.czechMonthToNumber(preg_replace('/\s(CE|ad)/', '', $date)).'</li>';
					}
				print '</ul></div>';
			}
			# --- Description
			if($this->request->config->get('ca_objects_description_attribute')) {
				if($vs_description_text = $t_object->get("ca_objects.".$this->request->config->get('ca_objects_description_attribute'))){
					print '<div class="item-description">'.$vs_description_text.'</div>';
				}
			}
			# --- parent hierarchy info
			if($t_object->get('parent_id')){
				$pid = $t_object->get('parent_id');
				$obj = new ca_objects($pid);
				if ($obj) {
					$va_access_values = caGetUserAccessValues($this->request);
					$acc = $obj->get('access');
					if (in_array($acc, $va_access_values)) {
						print "<div class='item-parent-hierarchy'><b class='heading'>"._t("Part Of")."</b>: ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', 'Detail', 'Object', 'Show', array('object_id' => $pid))."</div>";
					}
				}
			}
			# --- attributes
			$va_attributes = $this->request->config->get('ca_objects_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}")){
						print "<div class='item-attributes'><b>".$t_object->getDisplayLabel("ca_objects.{$vs_attribute_code}").":</b> {$vs_value}</div>";
					}
				}
			}
			# --- child hierarchy info
			$va_children = $t_object->get("ca_objects.children.preferred_labels", array('returnAsArray' => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_children) > 0){
				print "<div class='item-child-hierarchy'><b class='heading'>"._t("Part%1", ((sizeof($va_children) > 1) ? "s" : ""))."</b> ";
				$i = 0;
				print "<ul>";
				foreach($va_children as $va_child){
					# only show the first 5 and have a more link
					if($i == 5){
						print "<div id='moreChildrenLink'><a href='#' onclick='$(\"#moreChildren\").slideDown(250); $(\"#moreChildrenLink\").hide(1); return false;'>["._t("More")."]</a></div><!-- end moreChildrenLink -->";
						print "<div id='moreChildren' style='display:none;'>";
					}
					print "<li>".caNavLink($this->request, $va_child['name'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_child['object_id']))."</li>";
					$i++;
					if($i == sizeof($va_children)){
						print "</div><!-- end moreChildren -->";
					}
				}
				print "</ul>";
				print "</div>";
			}
			# --- entities
			$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities) > 0){	
?>
				<div class="item-entities"><b class='heading'><?php print _t("Related")." ".((sizeof($va_entities) > 1) ? _t("entities") : _t("entity")); ?></b>
<?php
				print "<ul>";
				foreach($va_entities as $va_entity) {
					print "<li>".(($this->request->config->get('allow_detail_for_ca_entities')) ? caNavLink($this->request, $va_entity["label"], '', 'Detail', 'Entity', 'Show', array('entity_id' => $va_entity["entity_id"])) : $va_entity["label"])." (".$va_entity['relationship_typename'].")</li>";
				}
				print "</ul>";
?>
				</div>
<?php
			}
			
			# --- occurrences
			$va_occurrences = $t_object->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_sorted_occurrences = array();
			if(sizeof($va_occurrences) > 0){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($va_occurrences as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = $va_occurrence;
				}
				
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
?>
						<div class="item-occurrences"><b class='heading'><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></b>
<?php
					print "<ul>";
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
						print "<li>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])." (".$va_info['relationship_typename'].")</li>";
					}
					print "</ul>";
					print "</div>";
				}
			}
			# --- collections
			$va_collections = $t_object->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$collections = array();
			if(sizeof($va_collections) > 0){
				$title = (sizeof($va_collections) == 1) ? _t('Collection') : _t('Collections');
				print "<div class='item-collections'><b class='heading'>".$title."</b>";
				print "<ul>";
				foreach($va_collections as $va_collection_info){
					$col = new ca_collections($va_collection_info['collection_id']);
					$desc = $col->get('description');
					print "<li>";
					$class = '';
					if (strlen($desc) > 0) $class = 'collection-link';
					print caNavLink($this->request, $va_collection_info['label'], $class, '', 'Browse', 'clearAndAddCriteria', array('facet' => 'collection_facet', 'id' => $va_collection_info['collection_id']));
					print " (".$va_collection_info['relationship_typename'].")";
					if (strlen($desc) > 0) print '<div class="description"><strong class="h">'.$va_collection_info['label'].'</strong><p>'.nl2br($desc).'</p>';
					print "</li>";
				}
				print "</ul>";
				print "</div>";
			}
			# --- vocabulary terms
			$va_terms = $t_object->get("ca_list_items", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				print "<div class='item-terms'><b class='heading'>"._t("Tags")."</b>";
				print "<ul>";
				foreach($va_terms as $va_term_info){
					print '<li>'.caNavLink($this->request, $va_term_info['label'], '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'term_facet', 'id' => $va_term_info['item_id'])).'</li>';
				}
				print "</ul>";
				print "</div>";
			}
			# --- places
			$va_places = $t_object->get("ca_places", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			
			if(sizeof($va_places) > 0){
				print "<div class='item-places'><b class='heading'>"._t("Related Place".((sizeof($va_places) > 1) ? "s" : ""))."</b>";
				$list = array();
				foreach($va_places as $va_place_info){
					$list[] = caNavLink($this->request, $va_place_info['label'], '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'place_facet', 'id' => $va_place_info['place_id']));
					
					// $list[] = (($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label']);
					// $list[] = (($this->request->config->get('allow_detail_for_ca_places')) ? $link : $va_place_info['label']);
				}
				print "<ul><li>". join(', </li><li>', $list) . "</li></ul>";
				print "</div>";
			}
			# --- map
			$attr = $this->request->config->get('ca_objects_map_attribute');
			if(sizeof($va_places) == 1) {
				$zoom = 8;
			} else {
				$zoom = null;
			}
			if($attr && $t_object->get($attr)){
				$o_map = new GeographicMap(200, 150, 'map');
				$o_map->mapFrom($t_object, $attr);
				print "<div class='item-map'>".$o_map->render('HTML', array('zoomLevel' => $zoom))."</div>";
			}			
			# --- output related object images as links
			// $va_related_objects = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			// if (sizeof($va_related_objects)) {
			// 	print "<div class='item-object-images'><b class='heading'>"._t("Related Objects")."</b>";
			// 	print "<table border='0' cellspacing='0' cellpadding='0' width='100%' id='objDetailRelObjects'>";
			// 	$col = 0;
			// 	$vn_numCols = 4;
			// 	foreach($va_related_objects as $vn_rel_id => $va_info){
			// 		$t_rel_object = new ca_objects($va_info["object_id"]);
			// 		$va_reps = $t_rel_object->getPrimaryRepresentation(array('icon', 'small'), null, array('return_with_access' => $va_access_values));
			// 		if($col == 0){
			// 			print "<tr>";
			// 		}
			// 		print "<td align='center' valign='middle' class='imageIcon icon".$va_info["object_id"]."'>";
			// 		print caNavLink($this->request, $va_reps['tags']['icon'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_info["object_id"]));
					
			// 		// set view vars for tooltip
			// 		$this->setVar('tooltip_representation', $va_reps['tags']['small']);
			// 		$this->setVar('tooltip_title', $va_info['label']);
			// 		$this->setVar('tooltip_idno', $va_info["idno"]);
			// 		TooltipManager::add(
			// 			".icon".$va_info["object_id"], $this->render('../Results/ca_objects_result_tooltip_html.php')
			// 		);
					
			// 		print "</td>";
			// 		$col++;
			// 		if($col < $vn_numCols){
			// 			print "<td align='center'><!-- empty --></td>";
			// 		}
			// 		if($col == $vn_numCols){
			// 			print "</tr>";
			// 			$col = 0;
			// 		}
			// 	}
			// 	if(($col != 0) && ($col < $vn_numCols)){
			// 		while($col <= $vn_numCols){
			// 			if($col < $vn_numCols){
			// 				print "<td><!-- empty --></td>";
			// 			}
			// 			$col++;
			// 			if($col < $vn_numCols){
			// 				print "<td align='center'><!-- empty --></td>";
			// 			}
			// 		}
			// 	}
			// 	print "</table></div>";
			// }
			# --- Credit
			$credit = $t_object->get('access_credit');
			if (strlen($credit)) {
				print '<div class="item-date">';
				print '<b class="heading">'._t('Credit & copyright').'</b>';
				print '<p>'.$credit.'</p>';
				print '</div>';
			}
?>
			<?php
			# --- Add to lightbox
			if ((!$this->request->config->get('dont_allow_registration_and_login')) && (!$this->request->config->get('disable_my_collections')) && $this->request->isLoggedIn()) {
					print '<div class="item-add">'.caNavLink($this->request, _t("Add to my collection"), '', '', 'Sets', 'addItem', array('object_id' => $t_object->get('object_id'))).'</div>';
			}
			# --- Share
			if($this->request->config->get('show_add_this')){
		?>
			<div class="item-share">
				<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script>
			</div>
		<?php
			} // endif $this->request->config->get('show_add_this')
		?>
