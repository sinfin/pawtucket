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
?>
	</div><!-- end searchNav --></div><!-- end searchNavBg -->
<?php } ?>