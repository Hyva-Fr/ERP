<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Dimmers for dashboard
	|--------------------------------------------------------------------------

	*/

	'dimmers' => [
		[
			'class' => 'App\\Dimmers\\Containers\\Banner',
			'size' => '2/3'
		],
		[
			'class' => 'App\\Dimmers\\Containers\\IpFilter',
			'size' => '1/3'
		],
	]
];