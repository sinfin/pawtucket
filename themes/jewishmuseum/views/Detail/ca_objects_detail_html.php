<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Detail/ca_objects_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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
	$t_object = 						$this->getVar('t_item');
	$vn_object_id = 					$t_object->get('object_id');
	$vs_title = 						$this->getVar('label');
	$va_access_values = 				$this->getVar('access_values');
	$t_rep = 							$this->getVar('t_primary_rep');
	$vn_num_reps = 					$t_object->getRepresentationCount(array("return_with_access" => $va_access_values));
	$vs_display_version =			$this->getVar('primary_rep_display_version');
	$va_display_options =			$this->getVar('primary_rep_display_options');
	$locale = substr($this->request->config->ops_config_settings['scalars']['LOCALE'], 0, 2);
	$collection_tree = 				$t_object->getCollectionHierarchy($locale, array('checkAccess' => $va_access_values));

	$idno_siblings = $t_object->getIdnoSiblings(array('checkAccess' => $va_access_values));

	$set = new ca_sets();
	$oe_code = $this->request->config->get('featured_set_name');
	$online_exhibitions = $set->getSetsForItem($t_object->tableNum(), $t_object->getPrimaryKey(), array('checkAccess' => $va_access_values));
	$online_exhibitions = caExtractValuesByUserLocale($online_exhibitions);
	if (count($online_exhibitions) > 0) {
		foreach ($online_exhibitions as $key => $value) {
			if ($value['set_code'] == $oe_code) unset($online_exhibitions[$key]);
		}
	}
?>
	<script type="text/javascript">
		if (!window.titleChanged) {
			window.titleChanged = true
			document.title = '<?php print $vs_title." | "._t($this->request->config->get("html_page_title")); ?>';
		}
	</script>
	<div id="detail">
		<?php
		if (count($online_exhibitions) > 0) {
		?>
		<div id="detail-online-exhibitions">
			<ul>
				<?php
					foreach ($online_exhibitions as $id => $oe) {
						$content = caNavLink($this->request, _t('Part of on-line exhibition').' '.$oe["name"], 'ribbon-link', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $id));
						print '<li>'.$content.'</li>';
					}
				?>
			</ul>
		</div>
		<?php
		}
		?>
		<div id="detail-right"><div class="inner">
			<span class="fullscreen-arrow ico-left"></span>
		<?php
			require_once('_detail_right_html.php');
		?>
		</div></div>
		
		<div id="detail-left">
			<?php
				include('_item_nav_html.php');
			?>

			<div class="title">
				<h1><?php print $vs_title; ?></h1>
				<?php
					$localeLogo = caGetUserLocaleRules();
					$localeLogo = array_keys($localeLogo['preferred']);
					$localeLogo = $localeLogo[0];
					print caNavLink($this->request, _t("Collections' catalogue"), "logo-small ".$localeLogo, "", "", "");
				?>
			</div>

			<ul class="tabs">
				<?php
					// $representations = $this->getVar("representations");
					$representations_images = $this->getVar("representations_images");
					$representations_audio = $this->getVar("representations_audio");
					$representations_video = $this->getVar("representations_video");
					$representations_rewrite = $this->getVar("representations_rewrite");
				?>
				<?php
					$class = ' class="active"';
					if ($representations_images) { print '<li'.$class.'><a href="#tab-images">' . _t('Images') . '</a></li>'; $class = ''; }
					if ($representations_audio) { print '<li'.$class.'><a href="#tab-audio">' . _t('Audio') . '</a></li>'; $class = ''; }
					if ($representations_video) { print '<li'.$class.'><a href="#tab-video">' . _t('Video') . '</a></li>'; $class = ''; }
					if ($representations_rewrite) { print '<li'.$class.'><a href="#tab-text">' . _t('Text') . '</a></li>'; $class = ''; }
					
					print '<li'.$class.'><a href="#tab-comments">' . _t('Comments') . '</a></li>';
				?>
			</ul>

			<div class="tab-content">
				<?php
					$class = ' class="active"';
					if ($representations_images) { require_once('_images_html.php'); $class = ''; }
					if ($representations_audio) { require_once('_audio_html.php'); $class = ''; }
					if ($representations_video) { require_once('_video_html.php'); $class = ''; }
					if ($representations_rewrite) { require_once('_rewrite_html.php'); $class = ''; }
					
					require_once('_user_data_html.php');
						
					// print require_once('_user_data_html.php');
				?>
			</div>
		</div>		
<?php

	include('_item_nav_html.php');

	if ($idno_siblings['siblings']) {			
?>		
		<div id="detail-full">
			<b class="heading"><?php print _t('From the archive'); ?></b>
			<div class="grid">
				<ul>
<?php
					$c = 1;
					foreach ($idno_siblings['siblings'] as $object) {
						$this->setVar('object', $object);
						$this->setVar('number', $c);
						print $this->render('../Results/_ca_objects_result_item.php');
						$c++;
					}	
?>					
				</ul>
			</div>
		</div>
		
<?php
	}
	require_once(__CA_LIB_DIR__.'/core/Parsers/COinS.php');
	
	print COinS::getTags($t_object);
	
	
?>
</div>