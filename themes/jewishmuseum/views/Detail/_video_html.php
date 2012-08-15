<div id="tab-video"<?php print $class; ?>>
	<ul>
<?php
	foreach ($representations_video as $id => $repre) {
		$size = array(
			'width' => $repre['info']['original']['WIDTH'],
			'height' => $repre['info']['original']['HEIGHT']
		);
		$ratio = $size['width']/$size['height'];
		$path = $repre['urls']['original'];
		print '<li data-id="'.$id.'">'.videoWrap($id, $path, $ratio).'</li>';
	}
?>
	</ul>
</div>