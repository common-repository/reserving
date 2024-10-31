<?php

namespace Reserving\extensions\elementor;
use Reserving\base\Extension;

final class Init extends Extension
{
	/**
	 * All Class should implement runner
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public static function get_services()
	{
		
		return [
			Elementor::class,
		];
	}

	
}
