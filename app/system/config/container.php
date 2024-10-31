<?php

/**
 * All Service Providers are registered here.
 * @version 1.0.0
 * @date    2022-02-26
 * @param dir path
 * @param type can be "ARRAY" "JSON"
 */


Reserving\system\config\Loader::getInstance(RESERVING_DIR_PATH . 'app/configs','ARRAY');
Reserving\system\config\Loader::getInstance(RESERVING_DIR_PATH . 'app/configs/options/posts','ARRAY');
Reserving\system\config\Loader::getInstance(RESERVING_DIR_PATH . 'app/configs/options/taxonomy','ARRAY');
Reserving\system\config\Loader::getInstance(RESERVING_DIR_PATH . 'app/configs/options/menu','ARRAY');
Reserving\system\config\Loader::getInstance(RESERVING_DIR_PATH . 'packages/Options/register','ARRAY');



