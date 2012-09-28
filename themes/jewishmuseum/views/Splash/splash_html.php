<?php 
	$va_access_values = $this->getVar('access_values');
?>
		<div id="home-featured">
			<ul>
				<?php
					$ribbon = _t("Collections' catalogue");
					foreach ($this->getVar("featured_content") as $id => $t_item) {
						$description = $t_item->get('description') ? '<p>'.shorten($t_item->get('description'), 400).'</p>' : '<p></p>';
						$img = $t_item->getPrimaryRepresentation(array('large'), array('large'), array('checkAccess' => $va_access_values));
						$img = carouselImg($img['tags']['large']);
						$linkImage = caNavLink($this->request, $img, '', 'Detail', 'Object', 'Show', array('object_id' =>  $id));
						$linkTitle = caNavLink($this->request, shorten($t_item->getLabelForDisplay()), '', 'Detail', 'Object', 'Show', array('object_id' =>  $id));
						$linkMore = caNavLink($this->request, _t("detail"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $id));
						$type = caNavLink($this->request, $t_item->getTypeName(), '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'type_facet', 'id' => $t_item->get('type_id')));
						$year = dateYear($t_item->get('periodization'));
						if ($year) {
							$year = caNavLink($this->request, $year['text'], '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'periodization_facet', 'id' => $year['search']));						
						}
						print "
							<li>
								<div class=\"img\">{$linkImage}</div>
								<div class=\"text\">
									<b class=\"ribbon\">{$ribbon}</b>
									<h2>{$linkTitle}</h2>
									<div class=\"year-type\">{$year}{$type}</div>
									{$description}
									<div class=\"more\">{$linkMore}</div>
								</div>
								<div class=\"clearfix-me\"></div>
							</li>
						";
					}
				?>
			</ul>
			<div id="home-featured-pagination"></div>
		</div>
	</div><!-- .content -->
</div><!-- #main -->
<div id="home-dark">
	<div id="home-dark-inner">
		<?php
			$online_exhibitions = $this->getVar("online_exhibitions");
			print '<ul class="count-'.count($online_exhibitions['sets']).'">';
			foreach ($online_exhibitions['sets'] as $vn_set_id => $va_set_info) {
				$img = (isset($online_exhibitions['images'][$vn_set_id])) ? $online_exhibitions['images'][$vn_set_id][0] : '';
				$img = caNavLink($this->request, $img, '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id));
				print '<li>';
					print '<div class="img">'.$img.'</div>';
					print '<div class="text">';
						print '<h3>'.caNavLink($this->request, shorten($va_set_info["name"], 35), '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id)).'</h3>';
						print '<div class="description">';
							print nl2br(shorten($online_exhibitions['descriptions'][$vn_set_id][0], 130));
						print '</div>';
						print '<div class="more">'.caNavLink($this->request, _t('detail'), '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $vn_set_id)).'</div>';
					print '</div>';
				print '</li>';
			}
			print '</ul>';
		?>
	</div>
	<span id="home-dark-left"><span class="ico"></span></span>
	<span id="home-dark-right"><span class="ico"></span></span>
	<span id="home-dark-more-link"></span>
	<?php print caNavLink($this->request, _t('More on-line exhibitions'), 'home-dark-more-link', 'simpleGallery', 'Show', 'Index'); ?>
</div>
<div id="main-home">
	<div class="sidebar">
		<b class="headline"><?php print _t('Recently catalogued'); ?></b>
		<?php print caNavLink($this->request, _t('more'), "", "", "Browse", "Index", ""); ?>
	</div>
	<div class="content">
		<div class="grid">
			<ul class="equal-height">
				<?php
					foreach ($this->getVar("recently_added_objects") as $id => $object) {
						$this->setVar('object', $object);
						print $this->render('Results/_ca_objects_result_item.php');
					}
				?>
			</ul>
		</div>
