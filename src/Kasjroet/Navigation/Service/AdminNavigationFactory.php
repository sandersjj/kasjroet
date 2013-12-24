<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 12/12/13
 * Time: 9:47 PM
 */

namespace Kasjroet\Navigation\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class AdminNavigationFactory extends DefaultNavigationFactory{

	protected function getName()
	{
		return 'adminmenu';
	}
} 