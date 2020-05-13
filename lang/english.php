<?php
	function lang($phrase) {
		static $lang = array(
			// Navbar Links
			'ALL_CASES' 					=> 'All cases',
			'ALL_DEATHS' 					=> 'All deaths',
			'ALL_RECOVERED' 			=> 'All recovered',
			'ALL_SERIOUS' 				=> 'All serious',

			'SEARCH' 							=> 'Search',

			'COUNTRIES' 					=> 'Countries',
			'TOTAL_CASES' 				=> 'Total cases',
			'NEW_CASES' 					=> 'New cases',
			'TOTAL_DEATHS' 				=> 'Total deaths',
			'NEW_DEATHS'					=> 'New deaths',
			'TOTAL_RECOVERED' 		=> 'Total recovered',
			'ACTIVE_CASES' 				=> 'Active cases',
			'SERIOS_CRITICAL' 		=> 'Serious critical',
			'TOTAL_CASES_1M_POP' 	=> 'Total cases 1m pop',
			'DEATHS_1M_POP' 			=> 'Deaths 1m pop',
			'DATE_FIRST_CASE' 		=> 'Date first case'
		);
		return $lang[$phrase];
	} ?>