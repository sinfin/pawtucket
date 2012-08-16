<?php 
 	require_once(__CA_MODELS_DIR__.'/ca_collections.php');
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_APP_DIR__.'/plugins/Collections/helpers/helpers.php');
 	require_once(__CA_LIB_DIR__.'/ca/ResultContext.php');
 
 	class HierarchyController extends ActionController {
 		# -------------------------------------------------------
 		private $opo_plugin_config;			// plugin config file
 		private $ops_theme;						// current theme
 		private $opo_result_context;			// current result context
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			// JavascriptLoadManager::register('panel');
 			// JavascriptLoadManager::register('onlineExhibition');
 			// JavascriptLoadManager::register('jquery', 'expander');
 			// JavascriptLoadManager::register('jquery', 'swipe');
 			
 			parent::__construct($po_request, $po_response, $pa_view_paths);
			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/Collections/conf/Collections.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('Collections plugin is not enabled')); }
 			
 			$this->ops_theme = __CA_THEME__;																		// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/Collections/views/'.$this->ops_theme)) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			
 			// $this->opo_result_context = new ResultContext($po_request, 'ca_objects', 'simple_gallery');
 		}
 		# -------------------------------------------------------
 		// public function Index() {
			// JavascriptLoadManager::register('hierarchy');
 		// 	$va_access_values = caGetUserAccessValues($this->request);
 			
 		// 	$t_collection = new ca_collections();
			// $o_db = $t_collection->getDb();
			// $access = implode(', ', $this->request->config->get('public_access_settings'));
			// $lang_code = substr($this->opo_plugin_config->ops_config_settings['scalars']['LOCALE'], 0, 2);

			// // Get trees
			// $qr_res = $o_db->query("
			// 	SELECT co.collection_id, cl.name, co.hier_collection_id AS tree, COUNT(ch.collection_id) as count
			// 	FROM ca_collections AS co JOIN ca_collections AS ch
			// 		LEFT JOIN ca_collection_labels AS cl ON cl.collection_id = ch.collection_id
			// 		LEFT JOIN ca_locales AS lo ON cl.locale_id = lo.locale_id			
			// 	WHERE
			// 		(co.access IN ({$access}) AND ch.access IN ({$access}))
			// 		AND co.hier_left = 1
			// 		AND ch.hier_collection_id = co.hier_collection_id
			// 		AND lo.language = '{$lang_code}'
			// 	GROUP BY tree
			// 	ORDER BY co.hier_collection_id ASC
			// ");			
			// $trees = array(); $ids = array();
			// while($qr_res->nextRow()) {
			// 	$trees[] = $qr_res->getRow();
			// }
			// $this->view->setVar('trees', $trees);
			// // Get nested array
			// // $qr_res = $o_db->query("
			// 	// SELECT co.collection_id, (COUNT(pa.collection_id) - 1) AS depth
			// 	// FROM ca_collections AS co, ca_collections AS pa
			// 	// WHERE
			// 		// (co.hier_left BETWEEN pa.hier_left AND pa.hier_right)
			// 		// AND (co.hier_collection_id = 2 AND pa.hier_collection_id = 2)
			// 		// AND (co.access IN ({$access}))
			// 	// GROUP BY pa.collection_id
			// 	// ORDER BY co.collection_id ASC
			// // ");
			// // $va_collections = array();
			// // while($qr_res->nextRow()) {
			// 	// $va_collections[] = $qr_res->getRow();
			// // }			
			// // print '<pre>';
			// 	// var_dump(nestify($va_collections));
			// // print '</pre>';
			// // $this->view->setVar('collections', $va_collections);
			// return $this->render($this->ops_theme . '/index.php');
 		// }
 		public function Show() {
			JavascriptLoadManager::register('hierarchy');
 			$va_access_values = caGetUserAccessValues($this->request);
 			
 			$collection_id = $this->request->getParameter('collection_id', pInteger);
 			$t_collection = new ca_collections($collection_id);
 			$name = caExtractValuesByUserLocale($t_collection->getPreferredLabels());
 			$name = current(current($name));
 			$name = $name['name'];
 			$av = $t_collection->get('access');
 			if (!in_array($av, $va_access_values)) {
				$this->response->setRedirect(caNavUrl($this->request, "", "Splash", "About"));
 			}
 			$t_collection = new ca_collections($t_collection->get('hier_collection_id'));
			$access = implode(', ', $this->request->config->get('public_access_settings'));
			$lang_code = substr($this->request->config->ops_config_settings['scalars']['LOCALE'], 0, 2);
			$tree = LoadTree($this->request, $collection_id, $access, $lang_code);

			if (!$tree) {
				$this->notification->addNotification(_t('Collection %1 has no children hierarchy.', $name), __NOTIFICATION_TYPE_ERROR__);
				$this->response->setRedirect(caNavUrl($this->request, "", "Splash", "About"));
			}

			$this->view->setVar('tree', $tree);
			$this->view->setVar('name', $name);
			$this->view->setVar('collection_id', $t_collection->get('collection_id'));

			return $this->render($this->ops_theme . '/index.php');
 		}
 	}
 ?>
