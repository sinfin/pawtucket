<?php
/* ----------------------------------------------------------------------
 * controllers/SplashController.php
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
 
 	require_once(__CA_LIB_DIR__."/ca/BaseBrowseController.php");
	require_once(__CA_LIB_DIR__."/core/Error.php");
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
	require_once(__CA_LIB_DIR__."/ca/Browse/ObjectBrowse.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 
 	class SplashController extends BaseBrowseController {
 		# -------------------------------------------------------
 		 /** 
 		 * Name of table for which this browse returns items
 		 */
 		 protected $ops_tablename = 'ca_objects';
 		 
 		/** 
 		 * Number of items per results page
 		 */
 		protected $opa_items_per_page = array(18, 24, 48);
 		#protected $opa_items_per_page = array(18);
 		 
 		/**
 		 * List of result views supported for this browse
 		 * Is associative array: keys are view labels, values are view specifier to be incorporated into view name
 		 */ 
 		protected $opa_views;
 		 
 		 
 		/**
 		 * List of available result sorting fields
 		 * Is associative array: values are display names for fields, keys are full fields names (table.field) to be used as sort
 		 */
 		protected $opa_sorts;
 		
 		
 		protected $ops_find_type = 'basic_browse';
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			// redirect user if not logged in
			if (($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn()))||($this->request->config->get('show_bristol_only')&&!($this->request->isLoggedIn()))) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "form"));
            } elseif (($this->request->config->get('show_bristol_only'))&&($this->request->isLoggedIn())) {
            	$this->response->setRedirect(caNavUrl($this->request, "bristol", "Show", "Index"));
            }
            
			$this->opo_browse = new ObjectBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');
			
			$this->opa_views = array(
				'full' => _t('List'),
				'thumbnail' => _t('Thumbnails')
			 );
			 
			$this->opa_sorts = array(
				'ca_object_labels.name' => _t('title'),
				'ca_objects.type_id' => _t('type'),
				'ca_objects.idno' => _t('idno')
			);
			
 			parent::__construct($po_request, $po_response, $pa_view_paths);
				
			$this->opo_browse = new ObjectBrowse($this->opo_result_context->getSearchExpression(), 'pawtucket2');
 		}
 		# -------------------------------------------------------
 		function Index() {
			// Remove any browse criteria previously set
			$this->opo_browse->removeAllCriteria();
 			parent::Index(true);
 			JavascriptLoadManager::register('home');
 			
 			$t_object = new ca_objects();
 			$t_featured = new ca_sets();
 			
 			if($this->request->config->get("dont_enforce_access_settings")){
 				$va_access_values = array();
 			}else{
 				$va_access_values = caGetUserAccessValues($this->request);
 			}
 			
 			$va_default_versions = array('thumbnail', 'icon', 'small', 'preview', 'medium', 'preview', 'widepreview');
 				
 			# --- featured items set - set name assigned in app.conf
			$t_featured->load(array('set_code' => $this->request->config->get('featured_set_name')));
			 # Enforce access control on set
 			if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_featured->get("access"), $va_access_values))){
	  			$this->view->setVar('featured_set_id', $t_featured->get("set_id"));
  				$va_tmp = $t_featured->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1));
 				$va_featured_ids = array_keys(is_array($va_tmp) ? $va_tmp : array());	// These are the object ids in the set
 			}
 			if(!is_array($va_featured_ids) || (sizeof($va_featured_ids) == 0)){
				# put a random object in the features variable
 				$va_featured_ids = array_keys($t_object->getRandomItems(10, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1)));
			}
			
			$featured_content = array();
			foreach ($va_featured_ids as $key => $value) {
				$t_object = new ca_objects($value);
				$featured_content[$value] = $t_object;
			}
			$this->view->setVar("featured_content", $featured_content);

			# --- online exhibitions
			$t_list = new ca_lists();
			$vn_public_set_type_id = $t_list->getItemIDFromList('set_types', $t_list->getAppConfig()->get('simpleGallery_set_type'));
			$va_sets = caExtractValuesByUserLocale($t_featured->getSets(array('table' => 'ca_objects', 'checkAccess' => $va_access_values, 'setType' => $vn_public_set_type_id)));
			$va_set_descriptions = $t_featured->getAttributeFromSets('description', array_keys($va_sets), array("checkAccess" => $va_access_values));
			$images = $t_featured->getAttributeFromSets('exhibition_cover_small', array_keys($va_sets), array("checkAccess" => $va_access_values, "version" => "thumbnail"));
			$this->view->setVar('online_exhibitions', array(
				'sets' => $va_sets,
				'descriptions' => $va_set_descriptions,
				'images' => $images
			));
			
			
 			# --- get the 12 most recently added objects to display
			$t_items = array();
			$va_recently_added_items = $t_object->getRecentlyAddedItems(12, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
			foreach(array_keys($va_recently_added_items) as $vn_object_id){
				$t_items[$vn_object_id] = new ca_objects($vn_object_id);
			}
			$this->view->setVar('recently_added_objects', $t_items)
 			$this->render('Splash/splash_html.php');
 		}
 		# -------------------------------------------------------
		public function browseName($ps_mode='singular') {
 			return ($ps_mode == 'singular') ? _t('browse') : _t('browses');
 		}
 		# ------------------------------------------------------
 		function About() {
 			$this->render('About/Index.php');
		}
 		# ------------------------------------------------------
 		function Contribute($values = array()) {
 			require_once(__CA_LIB_DIR__.'/vendor/recaptchalib.php');
 			$public_key = '6LeyQ9USAAAAAAZwGLypI3cOgXnVtk9JWbQr8t2e';
 			$this->view->setVar('values', $values);
 			$this->render('Contribute/Index.php');
		}
 		# -------------------------------------------------------
 		function Submit() {
 			require_once(__CA_LIB_DIR__.'/vendor/recaptchalib.php');
 			$private_key = $this->request->config->get('recaptcha_private_key');
 			if (empty($private_key)) $private_key = '6LeyQ9USAAAAADnDBtEsxwgjuTQ9JHSVubG0Z4xM';
 			$what = strip_tags($this->request->getParameter("what", pString));
 			$contact = strip_tags($this->request->getParameter("contact", pString));
 			$recaptcha_challenge_field = strip_tags($this->request->getParameter("recaptcha_challenge_field", pString));
 			$recaptcha_response_field = strip_tags($this->request->getParameter("recaptcha_response_field", pString));
 			$resp = recaptcha_check_answer ($private_key,
 			                                $_SERVER["REMOTE_ADDR"],
 			                                $recaptcha_challenge_field,
 			                                $recaptcha_response_field);
 			$error = 0;
			$size_limit = 10; 			
 			if (empty($what)) { $error++; $this->notification->addNotification(_t("You didn't fill the description field right.")); }
 			if (empty($contact)) { $error++; $this->notification->addNotification(_t("You didn't fill the contact field right.")); }
 			if (!$resp->is_valid) { $error++; $this->notification->addNotification(_t("You didn't answer the captcha right.")); }
			$email = $this->request->config->get('contribution_email_address');
			if (empty($email)) {
				$strTo = 'fotoarchiv@jewishmuseum.cz';
			} else {
				$strTo = $email;
			}
 			if ($error == 0) {
 				$attachment = false;

				$strSubject = 'Doplňte naše sbírky';
				$strMessage = "Odeslán formulář.\n\n";
				$strMessage .= "Kontakt:\n";
				$strMessage .= $contact;
				$strMessage .= "\n\nPředmět:\n";
				$strMessage .= $what;
				$strMessage = nl2br($strMessage);

				//*** Uniqid Session ***//
				$strSid = md5(uniqid(time()));

				$strHeader = "";
				$strHeader .= "From: Jewish Museum <noreply@jewishmuseum.cz>\n";

				$strHeader .= "MIME-Version: 1.0\n";
				$strHeader .= "Content-Type: multipart/mixed; boundary=\"".$strSid."\"\n\n";
				$strHeader .= "This is a multi-part message in MIME format.\n";

				$strHeader .= "--".$strSid."\n";
				$strHeader .= "Content-type: text/html; charset=utf-8\n";
				$strHeader .= "Content-Transfer-Encoding: 7bit\n\n";
				$strHeader .= $strMessage."\n\n";

				//*** Attachment ***//
				if(count($_FILES) > 0) {
					$total_size = 0;
					foreach ($_FILES as $file) {
						$total_size += $file['size'];
						if ($file['error'] == 2) $total_size += 2*$size_limit*1024*1024;
					}
					if ($total_size > $size_limit*1024*1024) {
						$error++; $this->notification->addNotification(_t("Total filesize is limited to %1 megabytes.", $size_limit));
					} else {
						foreach ($_FILES as $file) {
							if (!empty($file["name"])) {
								$strFilesName = $file["name"];
								$strContent = chunk_split(base64_encode(file_get_contents($file["tmp_name"])));
								$strHeader .= "--".$strSid."\n";
								$strHeader .= "Content-Type: application/octet-stream; name=\"".$strFilesName."\"\n";
								$strHeader .= "Content-Transfer-Encoding: base64\n";
								$strHeader .= "Content-Disposition: attachment; filename=\"".$strFilesName."\"\n\n";
								$strHeader .= $strContent."\n\n";
							}
						}
					}
				}
				if ($error == 0) {
					$flgSend = mail($strTo,$strSubject,null,$strHeader);
				} else {
					$flgSend = true;
				}
				if (!$flgSend) { $error++; $this->notification->addNotification(_t("There was an error trying to submit. Please try again later.")); }

				if ($error > 0) {
					$values = array(
						'what' => $what,
						'contact' => $contact
					);
 					$this::Contribute($values);
				} else {
	 				$this->render('Contribute/Submit.php');
				}
 			} else {
				$values = array(
					'what' => $what,
					'contact' => $contact
				);
 				$this::Contribute($values);
 			}
		}
 		# -------------------------------------------------------
 	}
 ?>