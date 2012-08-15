<div id="tab-video"<?php print $class; ?>>
	<ul>
<?php
	foreach ($representations_video as $id => $repre) {
		$path = $repre['urls']['original'];
		print '<li data-id="'.$id.'">'.videoWrap($id, $path).'</li>';
	}
?>
	</ul>
</div>