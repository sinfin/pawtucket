<?php
	$vo_result = 			$this->getVar('result');
	$vs_current_view = 		$this->getVar('current_view');
# --- mapped results are not paged
if(($this->getVar('num_pages') > 1)){
?>

	<div class='searchNavBg'><div class='searchNav'>
<?php		
			print '<div class="result-count">'._t('Found %1 results.', $this->getVar('num_hits')).'</div>';
			print "<div class='nav'>";

			$page = $this->getVar('page');
			$count = $this->getVar('num_pages');

			$pagination = createPagination($count, $page, $this->request, 5);
			print $pagination;

			// if ($page == 1) {
			// 	$p = 1;
			// 	print activePaginationLink($p);
			// } else {
			// 	$p = 1;
			// 	$url = caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $p));	
			// 	print paginationLink($p, $url);
			// }
			// $previous = $page - 1;
			// if ($previous > 1) {
			// 	$p = $previous;
			// 	$url = caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $p));	
			// 	print paginationLink($p, $url);	
			// }
			// $next = array($page + 1, $page + 2);
			// foreach ($next as $p) {
			// 	if ($p < $count) {
			// 		$url = caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $p));	
			// 		print paginationLink($p, $url);	
			// 	}
			// }
			// if ($page == $count) {
			// 	$p = $count;
			// 	print activePaginationLink($p);
			// } else {
			// 	$p = $count;
			// 	$url = caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $p));	
			// 	print paginationLink($p, $url);
			// }
			// $url = caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $page));
			// print '<pre>'; var_dump($page); print '</pre>';
			// print '<pre>'; var_dump($url); print '</pre>';
			// print paginationLink($page, $url);

			// if ($this->getVar('page') > 1) {
			// 	$prev = $this->getVar('page') - 1;
			// 	$url = caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $prev));
			// 	print '<a href="#page-'.$prev.'" class="pagination-link" data-url="'.$url.'"><span class="arrow-left"></span>'._t("Previous").'</a>';
			// } else {
			// 	print "<span class='linkOff'><span class=\"arrow-left\"></span>"._t("Previous")."</span>";
			// }

			// print '<span class="page current">'.$this->getVar('page').'</span>';
			// print '<span class="of">'._t('of').'</span>';
			// print '<span class="page count">'.$this->getVar('num_pages').'</span>';

			// if ($this->getVar('page') < $this->getVar('num_pages')) {
			// 	$next = $this->getVar('page') + 1;
			// 	$url = caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $next));
			// 	print '<a href="#page-'.$next.'" class="pagination-link" data-url="'.$url.'">'._t("Next").'<span class="arrow-right"></span></a>';

			// 	// print "<a href='#' onclick='jQuery(\"#resultBox\").addClass('working').load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') + 1))."\", function(){ jQuery(\"#resultBox\").removeClass('working'); }); return false;'>"._t("Next")."<span class=\"arrow-right\"></span></a>";
			// } else {
			// 	print "<span class='linkOff'>"._t("Next")."<span class=\"arrow-right\"></span></span>";
			// }

			// print '</div>';
			// print '<form action="#">'._t("Jump to page").': <input type="text" size="3" name="page" id="jumpToPageNum" value=""/>';
			// print '<a href="#jump-to" class="pagination-link from-input" data-url="'.caNavUrl($this->request, '', $this->request->getController(), 'Index', array()).'/page/">'._t("GO").'<span class="arrow-right"></span></a></form>';
		
		// $vn_num_hits = ;
		// print '<div style="margin-top:2px;">'._t('Your %1 found %2 %3.', $this->getVar('mode_type_singular'), $vn_num_hits, ($vn_num_hits == 1) ? _t('result') : _t('results'))."</div>";
?>
	</div><!-- end searchNav --></div><!-- end searchNavBg -->
<?php } ?>