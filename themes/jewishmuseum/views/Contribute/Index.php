<h1><?php print _t('Contribute to the collections'); ?></h1>
<div class="contribution">
	<form method="post" enctype="multipart/form-data" action="<?php print caNavUrl($this->request, 'Splash', 'Submit', array()); ?>" name="contribution" class="form">
		<p><?php print _t('If you have any documents, images or other material related to the aqctivities of the Jewish Museum in Prague and you think it would contribute to its collections, or if you want to share any kind of information, please fill out the following form. We will contact you shortly.'); ?></p>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php print 10*1024*1024; ?>" />
		<div>
			<b><?php print _t("Describe in detail what you are interested in contributing to the Museum"); ?></b>
			<textarea name="what" rows="8" cols="73"></textarea>
		</div>
		<div>
			<b><?php print _t("Please fill in your name and email address so that we can get back to you."); ?></b>
			<textarea name="contact" rows="8" cols="73"></textarea>
		</div>
		<div>
			<b><?php print _t("If you have images of what you wish to contribute, please upload them here"); ?></b>
			<input type="file" name="images" id="file-field" />
			<div class="info"><?php print _t("Only %1 allowed.", ".zip, .rar, .gz and .7z"); ?></div>
		</div>
		<div class="captcha">
			<?php
			  $public_key = '6LeyQ9USAAAAAAZwGLypI3cOgXnVtk9JWbQr8t2e';
			  echo recaptcha_get_html($public_key);
			?>
		</div>
		<div>
			<a href="#" name="login" class="ribbon-link" onclick="document.forms.contribution.submit(); return false;"><?php print _t("Submit"); ?></a>
		</div>
		<script type="text/javascript">
			$(function() {
				$('#file-field').on('change', function(){
					var ext = $(this).val().split('.').pop().toLowerCase();
					if($.inArray(ext, ['zip','rar','7z','gz']) == -1) {
					    alert("<?php print _t("Only %1 allowed.", ".zip, .rar, .gz and .7z"); ?>");
					}
				});
			});
		</script>
	</form>
</div>