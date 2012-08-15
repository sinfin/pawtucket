<div id="tab-audio"<?php print $class; ?>>
	<ul>
<?php
	foreach ($representations_audio as $id => $repre) {
		$full = $repre['tags']['original'];
		$name = $repre['label'];
		print "
			<li data-id=\"{$id}\">
				<div class=\"audio\">
					<strong class=\"name\">{$name}</strong>
					{$full}
				</div>
			</li>";
	}
?>
	</ul>
</div>