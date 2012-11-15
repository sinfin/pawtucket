<?php
if (!$this->request->config->get('dont_allow_registration_and_login')) {
		# --- user data --- comments - ranking - tagging
?>			
		<div id="tab-comments">
<?php
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
					$vs_login_message = _t("Login/register to comment on this object!");
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
				<div class="formLabel hide">Rank
					<select name="rank">
						<option value="">-</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
				<div class="hide">
					<b><?php print _t("Tags (separated by commas)"); ?></b>
					<input type="text" name="tags" size="100" />
				</div>
				<div>
					<b><?php print _t("By commenting you will send a message to the Jewish Museum in Prague."); ?></b>
					<textarea name="comment" rows="8" cols="73"></textarea>
				</div>
				<a href="#" name="commentSubmit" class="ribbon-link" onclick="document.forms.comment.submit(); return false;"><?php print _t("Send"); ?></a>
			</form>
<?php
		}else{
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				print "<p>".caNavLink($this->request, (($vs_login_message) ? $vs_login_message : _t("Login/register to comment on this object.")), "", "", "LoginReg", "form", array('site_last_page' => 'ObjectDetail', 'object_id' => $vn_object_id))."</p>";
			}
		}
?>		
		</div><!-- end objUserData-->
<?php
	} // endif $this->request->config->get('dont_allow_registration_and_login')
?>