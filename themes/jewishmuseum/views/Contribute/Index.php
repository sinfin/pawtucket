<?php
	$values = $this->getVar('values');
	$what = (isset($values['what'])) ? $values['what'] : '';
	$contact = (isset($values['contact'])) ? $values['contact'] : '';
?>
<h1><?php print _t('Contribute to the collections'); ?></h1>
<div class="contribution">
	<form method="post" enctype="multipart/form-data" action="<?php print caNavUrl($this->request, 'Splash', 'Submit', array()); ?>" name="contribution" class="form">
		<p><?php print _t('If you have any documents, images or other material related to the aqctivities of the Jewish Museum in Prague and you think it would contribute to its collections, or if you want to share any kind of information, please fill out the following form. We will contact you shortly.'); ?></p>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php print 10*1024*1024; ?>" />
		<div>
			<b><?php print _t("Describe in detail what you are interested in contributing to the Museum"); ?></b>
			<textarea name="what" rows="8" cols="73"><?php print $what; ?></textarea>
		</div>
		<div>
			<b><?php print _t("Please fill in your name and email address so that we can get back to you."); ?></b>
			<textarea name="contact" rows="8" cols="73"><?php print $contact; ?></textarea>
		</div>
		<div id="file-fields">
			<b><?php print _t("If you have images of what you wish to contribute, please upload them here"); ?></b>
			<input type="file" name="image1" data-id="1" class="new" />
			<div class="info"><?php print _t("Total filesize is limited to %1 megabytes.", "10"); ?></div>
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
				window.inputID = 1;
				$('#file-fields').on('change', '.new', function(){
					var t = $(this);
					var id = parseInt(t.data('id')) + 1;
					if (id == window.inputID) return false;
					window.inputID = id;
					var input = $('<input />').attr({
						'type': 'file',
						'name': 'image'+id,
						'data-id': id,
						'class': 'new'
					});
					t.removeClass('new');
					t.siblings('.info').before(input);
				});
			});
		</script>
	</form>
</div>