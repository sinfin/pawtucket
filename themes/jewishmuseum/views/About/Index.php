<h1>About the Archive</h1>
<div class="textContent">
	<div>
		Hierarchie:<br /><br />
		<?php
			print caNavLink($this->request, _t("SOAH"), "", "Collections", "Hierarchy", "Show", array('collection_id' => 2));
			print '<br />';
			print caNavLink($this->request, 'fungujici "podsbirka"', "", "Collections", "Hierarchy", "Show", array('collection_id' => 5));
			print '<br />';
			print caNavLink($this->request, 'bez potomku', "", "Collections", "Hierarchy", "Show", array('collection_id' => 171));
		?>
		<br /><br /><br /><br />
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sapien libero, consectetur vitae placerat 
		vitae, congue at odio. Cras urna lectus, hendrerit vitae tempor sit amet, dapibus sit amet libero. Nunc at 
		massa lorem, vel interdum dui. Sed id ante vitae elit tristique consequat. Morbi eu fringilla felis. Sed 
		euismod augue a elit adipiscing et tempor tellus iaculis. Etiam nec mollis dolor. Nam vulputate lorem eu 
		leo pretium eleifend. Vivamus eu varius mauris. Nunc mi massa, dictum in luctus vel, tempor sodales diam. 
		Morbi in nisi urna. In ac risus quis justo venenatis semper eget nec diam. Aenean sollicitudin ligula et mi 
		faucibus quis convallis justo eleifend.
	</div>
</div>