<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/search_refine_html.php 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2011 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$o_browse = $this->getVar('browse');
	
	$va_available_facets = $o_browse->getInfoForAvailableFacets();
	$va_facet_info = $o_browse->getInfoForFacets();
	$this->setVar('facet_info', $va_facet_info);
		
	if (sizeof($va_available_facets)) {// if we can refine, refine!
		$this->setVar('available_facets', $va_available_facets);
	}
	
	$va_criteria = $o_browse->getCriteriaWithLabels();
	if(sizeof($va_criteria) > 1){
		$this->setVar('criteria', $va_criteria);
	}

	print $this->render('Browse/_browse_controls.php');
?>