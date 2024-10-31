<?php

namespace Reserving\extensions\frontend;
use Reserving\base\Extension;

include_once(RESERVING_DIR_PATH .'app/extensions/frontend/blocks/helper.php');
include_once(RESERVING_DIR_PATH .'app/extensions/frontend/blocks/block_render.php');
include_once(RESERVING_DIR_PATH .'app/extensions/frontend/blocks/block.php');

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
			assets\Frontend::class,
			ajax\Ajax::class,
			shortcodes\Availability_Checker::class,
			shortcodes\Product_Single::class,
			shortcodes\Tip::class,
			shortcodes\Delivery_Info::class,
			shortcodes\Frontend_Dashboard::class,
			product\Product_Grid::class,
			product\Product_Single::class,
			cart\Cart_Modify::class,
			cart\Cart_Update::class,
			checkout\Checkout_Modify::class,
			order\Order_Modify::class,
			order\Thankyou::class
		];
	}
}
