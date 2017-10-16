<?php 
namespace Andre\Thelittlefoxesclub\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/gotoparent", name="gotoparent")
     * @Template()
     */
    public function indexAction()
    {
    	
    	    return $this->redirect($this->get('request')->getBaseUrl().'/account?grid%5Baccounts-grid%5D=i%3D1%26p%3D25%26s%255Bname%255D%3D-1%26f%255Bis_parent%255D%255Bvalue%255D%3D1%26c%3Dname1.contactName1.contactEmail1.contactPhone1.ownerName1.createdAt1.updatedAt1.is_parent1.parent1.tags1%26v%3D__all__%26a%3Dgrid');
    }
    /**
     * @Route("/gotochildren", name="gotochildren")
     * @Template()
     */
    public function index2Action()
    {
    	    return $this->redirect($this->get('request')->getBaseUrl().'/account?grid%5Baccounts-grid%5D=i%3D1%26p%3D25%26s%255Bname%255D%3D-1%26f%255Bis_parent%255D%255Bvalue%255D%3D2%26c%3Dname1.contactName1.contactEmail1.contactPhone1.ownerName1.createdAt1.updatedAt1.is_parent1.parent1.tags1%26v%3D__all__%26a%3Dgrid');
    }
}