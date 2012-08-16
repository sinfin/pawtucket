<?php
	$tree = $this->getVar('tree');
	$name = $this->getVar('name');
	$id = $this->getVar('collection_id');
?>
<div id="hierarchy-full">
	<h1><?php print _t("Hierarchy of").' '.$name; ?></h1>
	<?php
		print "<ul class=\"top\">";
			// $link = caNavLink($this->request, $name, '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'collection_facet', 'id' => $id));

			print $tree;
		print "</ul>";
	?>
</div>