<?php
	global $g_ui_locale;
?>
			<div id="loginForm">
				<strong class="h1"><?php print _t("Login"); ?></strong>
<?php
				if($this->getVar("loginMessage")){
					print "<div class='formErrors'>".$this->getVar("loginMessage")."</div>";
				}
?>
				<div class="bg">
					<form action="<?php print caNavUrl($this->request, '', 'LoginReg', 'login', array()); ?>" method="post" name="login" class="form">
						<div>
							<b><?php print _t("E-mail address"); ?></b>
							<input type="text" name="username" />
						</div>
						<div>
							<b><?php print _t("Password"); ?></b>
							<input type="password" name="password" />
						</div>
						<a href="#" name="login" class="ribbon-link" onclick="document.forms.login.submit(); return false;"><?php print _t("Login"); ?></a>
					</form>					
				</div><!-- end bg -->
				<div class="slide-link" style="<?php print ($this->getVar("resetFormOpen")) ? "display:none;" : ""; ?>"><a href="#"  onclick='jQuery("#resetPasswordLink").slideDown(1); $("#resetPasswordLink").slideUp(1); jQuery("#resetPassword").slideDown(250); jQuery("#loginForm").addClass("slided"); return false;' id="resetPasswordLink"><?php print _t("Forgot your password?"); ?></a></div>
				<div id="resetPassword" style="<?php print ($this->getVar("resetFormOpen")) ? "" : "display:none;"; ?>">
					<strong class="h1"><?php print _t("Reset your password"); ?></strong>
					<div class="bg">
				
						<form action="<?php print caNavUrl($this->request, '', 'LoginReg', 'resetSend'); ?>" name="reset_password" method="post" class="form">
							<p><?php print _t("To reset your password enter the e-mail address you used to register below. A message will be sent to the address with instructions on how to reset your password."); ?></p>
	<?php
							if($this->getVar("reset_email_error")){
								print "<div class='formErrors' style='text-align: left;'>".$this->getVar("reset_email_error")."</div>";
							}
	
	?>
							<div><b><?php print _t("E-mail address");; ?></b>
								<input type="text" name="reset_email" value="" /><a href="#" class="ribbon-link" onclick="document.forms.reset_password.submit(); return false;"><?php print _t("Reset"); ?></a>
							</div>
							<input type="hidden" name="action" value="send">
						</form>
					</div>
				</div>
				
			</div><!-- end loginForm -->
			<div id="registerForm">
				<strong class="h1"><?php print _t("Register"); ?></strong>
				<div class="bg">
					<form action="<?php print caNavUrl($this->request, '', 'LoginReg', 'register', array()); ?>" method="post" name="registration" class="form">
						<p><?php print _t("As a member, you can comment on objects."); ?></p>
<?php
						$va_errors = $this->getVar("reg_errors");
						
						print $this->getVar("fname");
						print $this->getVar("field_of_research");
						print $this->getVar("lname");
						print $this->getVar("email");
						print $this->getVar("password");
?>
						<div><b><?php print _t('Re-type password'); ?></b><input type="password" name="password2" size="60" />
						<div class="captcha">
							<?php
								$public_key = $this->request->config->get('recaptcha_public_key');
								if (empty($public_key)) $public_key = '6LeyQ9USAAAAAAZwGLypI3cOgXnVtk9JWbQr8t2e';
								echo recaptcha_get_html($public_key);
							?>
						</div>
			
						<a href="#" name="register" class="ribbon-link" onclick="document.forms.registration.submit(); return false;"><?php print _t("Register"); ?></a></div>
									
						<input type="hidden" name="sum" value="<?php print $vn_sum; ?>">
					</form>					
				</div><!-- end bg -->
			</div><!-- end registerForm -->
