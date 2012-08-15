<div id="pdf"<?php print $class; ?>>
	<ul>
<?php
	foreach ($representations_pdf as $id => $repre) {
		$full = $repre['tags']['original'];
		$name = $repre['label'];
		print "
			<li data-id=\"{$id}\">
				<div class=\"pdf\">
					<strong class=\"name\">{$name}</strong>
					{$full}
				</div>
			</li>";
	}
?>
	</ul>
</div>