<?php
function checkId($item, $id) {
	return ($item['collection_id'] == $id);
}
function filterTree($tree, $id) {
	foreach ($tree as $t) {
		if (checkId($t, $id)) {
			return $t;
		} else {
			if (count($t['children']) > 0) {
				return filterTree($t['children'], $id);
			} else {
				return false;
			}
		}
	}
}
function filterRelevant($tree, $id) {
	return filterTree($tree, $id);
}
function toHierarchy($collection, $id) {
	// Trees mapped
	$trees = array();
	$l = 0;

	if (count($collection) > 0) {
		// Node Stack. Used to help building the hierarchy
		$stack = array();
		foreach ($collection as $node) {
			$item = $node;
			$item['children'] = array();

			// Number of stack items
			$l = count($stack);

			// Check if we're dealing with different levels
			while($l > 0 && $stack[$l - 1]['depth'] >= $item['depth']) {
				 array_pop($stack);
				 $l--;
			}

			// Stack is empty (we are inspecting the root)
			if ($l == 0) {
				// Assigning the root node
				$i = count($trees);
				$trees[$i] = $item;
				$stack[] = & $trees[$i];
			} else {
				// Add node to parent
				$i = count($stack[$l - 1]['children']);
				$stack[$l - 1]['children'][$i] = $item;
				$stack[] = & $stack[$l - 1]['children'][$i];
			}
		}
	}
	return $trees;
}			
function printRecursive($request, $array, $depth = 0) {
	$c = count($array);
	$i = 0;
	$print = '';
	foreach ($array as $collection) {
		$i++;
		$class = '';
		if ($i == 1) $class = 'first';
		if ($i == $c) $class .= ' last';
		$link = caNavLink($request, $collection['name'], '', '', 'Browse', 'clearAndAddCriteria', array('facet' => 'collection_facet', 'id' => $collection['collection_id']));
		if (is_array($collection['children']) && sizeof($collection['children'])) {
			$print .= "<li class=\"parent {$class} open closed\">{$link}<span class=\"icons open closed\"><span class=\"ico ico-folder\"></span><span class=\"ico ico-sign\"></span></span>";
			$print .= "<ul class=\"sub\">";
				$print .= printRecursive($request, $collection['children'], ($depth+1));
			$print .= "</ul>";
			$print .= "</li>";
		} else {
			$print .= "<li class=\"{$class}\">{$link}<span class=\"ico ico-file\"></span></li>";
		}
	}		
	return $print;		
}
function LoadTree($request, $collection_id, $access, $lang_code) {
	$id = $collection_id;		
	$t_collection = new ca_collections($id);
	$hid = $t_collection->get('hier_collection_id');
	$o_db = $t_collection->getDb();
	$qr_res = $o_db->query("
		SELECT co.collection_id, (COUNT(pa.collection_id) - 1) AS depth
		FROM ca_collections AS co JOIN ca_collections AS pa
		WHERE
			(co.hier_left BETWEEN pa.hier_left AND pa.hier_right)
			AND (co.hier_collection_id = {$hid} AND pa.hier_collection_id = {$hid})
			AND (co.access IN ({$access}) AND pa.access IN ({$access}))
		GROUP BY co.collection_id
		ORDER BY co.hier_left ASC
	");
	$va_collections = array();
	$ids = array();
	while($qr_res->nextRow()) {
		$va_collections[] = $qr_res->getRow();
		$ids[] = $qr_res->get('collection_id');
	}
	$labels = $t_collection->getPreferredDisplayLabelsForIDs($ids);
	foreach ($va_collections as $key => $col) {
		$id = $col['collection_id'];
		$va_collections[$key]['name'] = $labels[$id];
	}
	$trees = toHierarchy($va_collections, $collection_id);
	$relevant_tree = filterRelevant($trees, $collection_id);
	if ($relevant_tree) {
		$res = printRecursive($request, array($relevant_tree));
	} else {
		$res = false;
	}
	return $res;
	// exit();
}
?>