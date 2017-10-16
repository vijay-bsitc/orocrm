<?php 
namespace Andre\Thelittlefoxesclub\ContactBundle\Controller\Api\Rest;

use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;

/**
 * @RouteResource("weekly")
 * @NamePrefix("contact_api_")
 */
class WeeklyController extends RestController
{
    /**
     * @Acl(
     *      id="contact.weekly_delete",
     *      type="entity",
     *      class="ContactBundle:Weekly",
     *      permission="DELETE"
     * )
     */
    public function deleteAction($id)
    {
        return $this->handleDeleteRequest($id);
    }

    public function getForm()
    {
    }

    public function getFormHandler()
    {
    }

    public function getManager()
    {
        return $this->get('contact.weekly_manager.api');
    }
}