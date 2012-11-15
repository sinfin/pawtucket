<?php
	$t_set 				= $this->getVar('t_set');			// object for ca_sets record of set we're currently editing
	$t_new_set 			= $this->getVar('t_set');			// object for ca_sets record of set we're currently editing
	$vn_set_id 			= $t_set->getPrimaryKey();		// primary key of set we're currently editing
	$va_items 			= $this->getVar('items');			// array of items in the set we're currently editing

	$va_sets 			= $this->getVar('set_list');		// list of existing sets this user has access to

	$t_set_description 			= $this->getvar("set_description");

	$va_errors 			= $this->getvar("errors");
	$va_errors_edit_set = $this->getVar("errors_edit_set");
	$va_errors_new_set 	= $this->getVar("errors_new_set");

	$ac = ($this->getVar("set_access") == 1) ? _t('Public') : _t('Private');
	$ac = strtolower($ac);
	# --- current set info and form to edit
	print '<ul id="my-collections-toggles">';
		# new link
		print '<li><a href="#new" id="my-collections-new">'._t("Create new collection").'</a></li>';
		if ($vn_set_id) {
			# edit link
			print '<li><a href="#edit" id="my-collections-edit">'._t("Edit current collection").'</a></li>';
		}
	print '</ul>';
	?>
	<div id="my-collections-form-new" class="hide">
		<form action="<?php print caNavUrl($this->request, 'Sets', 'addNewSet', ''); ?>" method="post" id="newSetForm">
<?php
			if($va_errors_new_set["name"]){
				print "<div class='formErrors' style='text-align: left;'>".$va_errors_new_set["name"]."</div>";
			}
?>
			<div class="formLabel"><?php print _t("Title"); ?></div>
			<input type="text" name="name">
			<div class="formLabel"><?php print _t("Display Option"); ?></div>
		<select name="access" id="access">
			<option value="0"><?php print _t("Private"); ?></option>
			<option value="1"><?php print _t("Public"); ?></option>
		</select>
			<div class="formLabel"><?php print _t("Description"); ?></div>
			<textarea name="description" rows="5"></textarea> 
			<div class="submit-div">
				<a href="#" name="newSetSubmit" class="ribbon-link" onclick="document.forms.newSetForm.submit(); return false;"><?php print _t("Create"); ?></a>
			</div>
		</form>
	</div>
	<?php	
	if ($vn_set_id) {
	?>				
		<div id="my-collections-form" class="hide">
	<?php
			if($va_errors_edit_set["edit_set"]){
				print "<div class='formErrors'>".$va_errors_edit_set["edit_set"]."</div>";
			}
	?>
			<form action="<?php print caNavUrl($this->request, 'Sets', 'saveSetInfo', ''); ?>" method="post" id="editSetForm">
	<?php
				if($va_errors_edit_set["name"]){
					print "<div class='formErrors' style='text-align: left;'>".$va_errors_edit_set["name"]."</div>";
				}
	?>
				<div class="formLabel"><?php print _t("Title"); ?></div>
				<input type="text" name="name" value="<?php print htmlspecialchars($t_set->getLabelForDisplay(), ENT_QUOTES, 'UTF-8'); ?>">
				<div class="formLabel"><?php print _t("Display Option"); ?></div>
				<select name="access" id="access">
					<option value="0" <?php print ($this->getVar("set_access") == 0) ? "selected" : ""; ?>><?php print _t("Private"); ?></option>
					<option value="1"  <?php print ($this->getVar("set_access") == 1) ? "selected=" : ""; ?>><?php print _t("Public"); ?></option>
				</select>
				<div class="formLabel"><?php print _t("Description"); ?></div>
				<textarea name="description" rows="5"><?php print htmlspecialchars($t_set_description); ?></textarea>
				<input type='hidden' name='set_id' value='<?php print $vn_set_id; ?>'/>

				<div class="submit-div">
					<a href="#" name="newSetSubmit" class="ribbon-link" onclick="document.forms.editSetForm.submit(); return false;"><?php print _t("Edit"); ?></a>
				</div>
			</form>

		</div><!-- end editForm -->
	<?php
	}
?>

		<span class="heading"><?php print _t("Your Collections"); ?></span>
<?php
	print '<ul>';
		foreach($va_sets as $va_set) {
			$class = ($va_set['set_id'] == $vn_set_id) ? 'current' : '';
			$link = caNavLink($this->request, $va_set['name'], $class, '', 'Sets', 'index', array('set_id' => $va_set['set_id']));
			print '<li>'.$link.'</li>';
		}
	print '</ul>';
?>