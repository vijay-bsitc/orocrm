<?php
// src/Acme/Bundle/NewBundle/AcmeNewBundle.php
namespace Andre\Thelittlefoxesclub\ContactBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContactBundle extends Bundle
{
	public function getParent()
    {
        //return 'OroUserBundle';
        return 'OroAccountBundle';
    }
}