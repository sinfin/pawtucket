<?php
	$notifications = $this->getVar('notifications');
	if (sizeof($notifications)) {
		$text = '<div id="notification-src">';
		foreach ($notifications as $value) {
			$text .= $value['message'].'<br />';
		}
		$text = substr($text, 0, -6);
		$text .= '</div>';
		print $text;
	}
?>