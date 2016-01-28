<?php

namespace Gfi\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GfiUserBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
