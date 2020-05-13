<?php
	function lang($phrase) {
		static $lang = array(
			// Navbar Links
			'ALL_CASES' 			=> 'الإصابات ',
			'ALL_DEATHS' 			=> 'الوفيات',
			'ALL_RECOVERED' 		=> 'المتعافين',
			'ALL_SERIOUS' 			=> 'الحالات الحرجة',

			'SEARCH' 				=> 'بحث ...',

			'COUNTRIES' 			=> 'جميع الدول',
			'TOTAL_CASES' 			=> 'مجموع الإصابات',
			'NEW_CASES' 			=> 'الإصابات اليوم',
			'TOTAL_DEATHS' 			=> 'مجموع الوفيات',
			'NEW_DEATHS'			=> 'الوفيات اليوم',
			'TOTAL_RECOVERED' 		=> 'مجموع المتعافين',
			'ACTIVE_CASES' 			=> 'الإصابات النشطة',
			'SERIOS_CRITICAL' 		=> 'الإصابات الحرجة',
			'TOTAL_CASES_1M_POP' 	=> 'الإصابات لكل مليون',
			'DEATHS_1M_POP' 		=> 'الوفيات لكل مليون',
			'1ST_CASE' 				=> 'تاريخ أول إصابة',
		);
		return $lang[$phrase];
	} ?>