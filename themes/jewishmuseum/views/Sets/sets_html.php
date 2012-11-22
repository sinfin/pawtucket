<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Sets/sets_html.php : 
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
 
	global $g_ui_locale;
	
	$t_set 				= $this->getVar('t_set');			// object for ca_sets record of set we're currently editing
	$vn_set_id 			= $t_set->getPrimaryKey();		// primary key of set we're currently editing
	$va_items 			= $this->getVar('items');			// array of items in the set we're currently editing
	
	$va_sets 			= $this->getVar('set_list');		// list of existing sets this user has access to
	$t_set_description 			= $this->getvar("set_description");

	$va_errors 			= $this->getvar("errors");
	$va_errors_edit_set = $this->getVar("errors_edit_set");
	$va_errors_new_set 	= $this->getVar("errors_new_set");

	$ac = ($this->getVar("set_access") == 1) ? _t('Public') : _t('Private');
	$ac = strtolower($ac);
?>
<h1>
	<?php
	if ($vn_set_id) {
		print $this->getVar("set_name");
		print ' <small>'.$ac.' '._t('collection').'</small>';
	} else {
		print _t('My collections');	
	}
	?>
</h1>
<?php
	if ($t_set_description) {
		print '<p class="intro-description">'.$t_set_description.'</p>';
	}
?>
<div id="my-collections-editor">
	<?php include '_sets_editor.php'; ?>
</div>

<div id="setItemEditor">
	<div id="leftCol">
<?php
		if (!sizeof($va_sets)) {
			// no sets for this user
?>
					<div class="error">
<?php
						print _t('There are no collections to edit. Create a collection to start.');
?>
					</div>
<?php		
		} else {
			if (!$vn_set_id) {
				// no set selected for editing
?>
					<div class="error">
<?php
						print _t('Choose a collection to begin editing.');
?>
					</div>
<?php			
			} else {
				if (!is_array($va_items) || (!sizeof($va_items) > 0)) {
					// set we're editing is empty
?>
					<div class="error">
<?php
						print _t('There are no items in this collection.');
?>
					</div>
<?php
				}
			}
		}
		if($this->getvar("message")){
			// print "<div class='message'>".$this->getvar("message")."</div>";
		}
		if(sizeof($va_errors) > 0){
			print "<div class='message'>".implode(", ", $va_errors)."</div>";
		}
?>
	<div id="setItems" class="grid">
		<ul id="setItemList" class="no-imagesloaded">
<?php
		if (is_array($va_items) && (sizeof($va_items) > 0)) {
			$ids = extractObjectIds($va_items);
			$object = new ca_objects();
			$years = $object->getAttributeForIDs('periodization', $ids);
			$types = $object->getTypeNamesForIDs($ids);
			foreach($va_items as $vn_item_id => $va_item) {
				$id = $va_item['object_id'];
				$title = caNavLink($this->request, shorten($va_item['name']), '', 'Detail', 'Object', 'Show', array('object_id' => $id));
				if ($va_item['representation_tag_thumbnail']) {
					$img = caNavLink($this->request, $va_item['representation_tag_thumbnail'], '', 'Detail', 'Object', 'Show', array('object_id' => $id));
				} else {
					$img = '';
				}
				$year = (isset($years[$id])) ? dateYear($years[$id][0]) : false;
				if ($year) {
					$year = caNavLink($this->request, $year['text'], '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'periodization_facet', 'id' => $year['search']));
				}
				$type = (isset($types[$id])) ? caNavLink($this->request, $types[$id], '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'type_facet', 'id' => $va_item['type_id'])) : false;
?>
				<li class="item-no-number with-ico" id="setItem<?php print $vn_item_id; ?>">
					<a href="#delete" class="setDeleteButton ico-close" id="setItemDelete<?php print $vn_item_id; ?>" title="<?php print _t('Remove item from set'); ?>"></a>
<?php
					print '<div class="img">' . $img . '</div>';
										
?>
					<div class="text">
						<?php
							print "<h2>{$title}</h2>";
							if ($year) {
								print '<div class="date">'.$year.'</div>';
							}
							if ($type) {
								print '<div class="type">'.$type.'</div>';
							}
							print '<div class="more">';
								print caNavLink($this->request, _t('detail'), 'fullscreen-target', 'Detail', 'Object', 'Show', array('object_id' => $id));
							print '</div>';
						?>
					</div>
				</li>
<?php	
			}
		}
?>
		</ul>
	</div><!-- end setItems -->
</div><!-- leftCol -->
	<script type="text/javascript">
		jQuery(".setDeleteButton").click(
			function() {
				var id = this.id.replace('setItemDelete', '');
				jQuery.getJSON('<?php print caNavUrl($this->request, '', 'Sets', 'DeleteItem'); ?>', {'set_id': '<?php print $vn_set_id; ?>', 'item_id':id} , function(data) { 
					if(data.status == 'ok') { 
						jQuery('#setItem' + data.item_id).fadeOut(500, function() { jQuery('#setItem' + data.item_id).remove(); });
					} else {
						alert('Error: ' + data.errors.join(';')); 
					}
				});
				return false;
			}
		);
		
		// function _makeSortable() {
		// 	jQuery("#setItemList").sortable({ opacity: 0.7, 
		// 		revert: true, 
		// 		scroll: true , 
		// 		handle: $(".setItem").add(".imagecontainer a img") ,
		// 		update: function(event, ui) {
		// 			jQuery.getJSON('<?php print caNavUrl($this->request, '', 'Sets', 'ReorderItems'); ?>', {'set_id': '<?php print $vn_set_id; ?>', 'sort':jQuery("#setItemList").sortable('toArray').join(';')} , function(data) { if(data.status != 'ok') { alert('Error: ' + data.errors.join(';')); }; });
		// 		}
		// 	});
		// }
		// _makeSortable();
	</script>
</div><!-- end setItemEditor -->