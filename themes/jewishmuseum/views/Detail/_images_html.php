<div id="tab-images"<?php print $class; ?>>
	<div id="detail-left-pagination">
		<span id="fullscreen-toggle">Fullscreen<span class="ico-fullscreen"></span></span>
		<div class="clear"></div>
	</div>
	<ul>
<?php
	$idno = $t_object->get('idno');
	$displayWatermark = strpos($idno, 'JMP');
	if ($displayWatermark) {
		$localeWm = caGetUserLocaleRules();
		$localeWm = array_keys($localeWm['preferred']);
		$localeWm = $localeWm[0];
		$watermark = '<span class="watermark '.$localeWm.'"></span>';
	} else {
		$watermark = '';
	}
	foreach ($representations_images as $id => $repre) {
		$image = '<div class="small">'.detailImg($repre['tags']['large']).$watermark.'</div>';
		$image .= '<div class="big">'.detailImg($repre['tags']['fullscreen']).$watermark.'</div>';
		// $title = $repre['title'] ? $repre['title'].' ' : '';
		// if ($repre['title']) {
			// $title = '<div class="label"><small>'.$repre['title'].'</small></div>';
		// }
		// $title = $repre['title'] ? $repre['title'] : '';
		// $full = '';
		print "
			<li data-id=\"{$id}\">
				{$image}
			</li>";
	}
?>
	</ul>
</div>