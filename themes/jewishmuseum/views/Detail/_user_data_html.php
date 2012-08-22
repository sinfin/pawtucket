<?php
if (!$this->request->config->get('dont_allow_registration_and_login')) {
		# --- user data --- comments - ranking - tagging
?>			
		<div id="tab-comments">
<?php
			if($this->getVar("ranking")){
?>
				<b class="form-label"><?php print _t("Average User Ranking"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/user_ranking_<?php print $this->getVar("ranking"); ?>.gif" width="104" height="15" border="0"></b>
<?php
			}
			$va_tags = $this->getVar("tags_array");
			if(is_array($va_tags) && sizeof($va_tags) > 0){
				$va_tag_links = array();
				foreach($va_tags as $vs_tag){
					$va_tag_links[] = caNavLink($this->request, $vs_tag, '', '', 'Search', 'Index', array('search' => $vs_tag));
				}
?>
				<h2 class="tags"><?php print _t("Tags"); ?></h2>
				<div id="tags">
					<?php print implode($va_tag_links, ", "); ?>
				</div>
<?php
			}
			$va_comments = $this->getVar("comments");
			if(is_array($va_comments) && (sizeof($va_comments) > 0)){
?>
				<h2 class="comments-h2"><!--<div id="numComments">(<?php print sizeof($va_comments)." ".((sizeof($va_comments) > 1) ? _t("comments") : _t("comment")); ?>)</div>--><?php print _t("User Comments"); ?></h2>
<?php
				foreach($va_comments as $va_comment){
?>
					<div class="comment">
						<div class="text"><?php print $va_comment["comment"]; ?></div>
						<div class="byLine">
							<?php print $va_comment["author"].", ".$va_comment["date"]; ?>
						</div>
					</div>
<?php
				}
			}else{
				if(!$vs_tags && !$this->getVar("ranking")){
					$vs_login_message = _t("Login/register to be the first to rank, tag and comment on this object!");
				}
			}
			if($this->getVar("ranking") || (is_array($va_tags) && (sizeof($va_tags) > 0)) || (is_array($va_comments) && (sizeof($va_comments) > 0))){
?>
				<div class="divide" style="margin:12px 0px 10px 0px;"><!-- empty --></div>
<?php			
			}
		if($this->request->isLoggedIn()){
?>
			<form method="post" action="<?php print caNavUrl($this->request, 'Detail', 'Object', 'saveCommentRanking', array('object_id' => $vn_object_id)); ?>" name="comment" class="form">
				<b><?php print _t("Add your rank, tags and comment"); ?></b>
				<div class="formLabel">Rank
					<select name="rank">
						<option value="">-</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
				<div>
					<b><?php print _t("Tags (separated by commas)"); ?></b>
					<input type="text" name="tags" size="100" />
				</div>
				<div>
					<b><?php print _t("Comment"); ?></b>
					<textarea name="comment" rows="8" cols="73"></textarea>
				</div>
				<a href="#" name="commentSubmit" class="ribbon-link" onclick="document.forms.comment.submit(); return false;"><?php print _t("Save"); ?></a>
			</form>
<?php
		}else{
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				print "<p>".caNavLink($this->request, (($vs_login_message) ? $vs_login_message : _t("Please login/register to rank, tag and comment on this item.")), "", "", "LoginReg", "form", array('site_last_page' => 'ObjectDetail', 'object_id' => $vn_object_id))."</p>";
			}
		}
?>		
		</div><!-- end objUserData-->
<?php
	} // endif $this->request->config->get('dont_allow_registration_and_login')
?>