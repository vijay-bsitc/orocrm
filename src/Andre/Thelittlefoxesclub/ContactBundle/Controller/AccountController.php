<?php

namespace Andre\Thelittlefoxesclub\ContactBundle\Controller;

use Oro\Bundle\AccountBundle\Controller\AccountController as BaseController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;
use Oro\Bundle\AccountBundle\Entity\Account;
use Oro\Bundle\ChannelBundle\Entity\Channel;
use Andre\Thelittlefoxesclub\ContactBundle\Entity\Authperson;

class AccountController extends BaseController
{
    
   /**
     * @Route("/view/{id}", name="oro_account_view", requirements={"id"="\d+"})
     * @Acl(
     *      id="oro_account_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="OroAccountBundle:Account"
     * )
     * @Template()
     */
    public function viewAction(Account $account)
    {
        //die("sdf sfsdfg sf");

        $channels = $this->getDoctrine()
            ->getRepository('OroChannelBundle:Channel')
            ->findBy([], ['channelType' => 'ASC', 'name' => 'ASC']);

        $customers = $this->getDoctrine()
            ->getRepository('OroMagentoBundle:Customer')
            ->findBy(['account' => $account->getId()]);

        
            $obj = new \stdClass();
            if($account->getParent())
            {
                $parentid = $account->getParent()->getId();

                $obj->is_parent = true;
                $obj->spouse = $account->getParent()->getSpouse();
                $obj->authorizedPerson = [];
                $obj->children = array();

                $child = $this->getDoctrine()
                            ->getRepository('OroAccountBundle:Account')
                            ->findBy(['parent' => $parentid]);

                $Authperson = $this->getDoctrine()
                            ->getRepository('ContactBundle:Authperson')
                            ->findBy(['accountId' => $parentid]);
                /*\Doctrine\Common\Util\Debug::dump($Authperson);*/
                if($Authperson && count($Authperson)>0){
                    foreach ($Authperson as $key => $value) {
                        $obj->authorizedPerson[] = $value->getName();
                    }
                }



                
                foreach ( $child as $key => $value) {
                    
                    $temp = new \stdClass();
                    $temp->id = $value->getId();
                    $temp->name = $value->getName();
                    $obj->children[] = $temp;
                }
            }
            else
            {
                $obj->is_parent = false;
                $parentid = $account->getId();
                $obj->spouse = $account->getSpouse();
                $obj->authorizedPerson = [];
                $obj->children = array();

                $child = $this->getDoctrine()
                            ->getRepository('OroAccountBundle:Account')
                            ->findBy(['parent' => $parentid]);

                $Authperson = $this->getDoctrine()
                            ->getRepository('ContactBundle:Authperson')
                            ->findBy(['accountId' => $parentid]);
                /*\Doctrine\Common\Util\Debug::dump($Authperson);*/
                if($Authperson && count($Authperson)>0){
                    foreach ($Authperson as $key => $value) {
                        $obj->authorizedPerson[] = $value->getName();
                    }
                }

               
                foreach ( $child as $key => $value) {
                    $temp = new \stdClass();
                    $temp->id = $value->getId();
                    $temp->name = $value->getName();
                    $obj->children[] = $temp;
                }

                
            }


        
        


        return [
            'entity' => $account,
            'channels' => $channels,
            'customers' => $customers,
            'memberinfo' => $obj
        ];
    }
}
