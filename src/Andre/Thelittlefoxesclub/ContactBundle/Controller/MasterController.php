<?php 
namespace Andre\Thelittlefoxesclub\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Andre\Thelittlefoxesclub\ContactBundle\Entity\Master;
use Symfony\Component\HttpFoundation\Request;

use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

/**
 * @Route("/master")
 */
class MasterController extends Controller
{
    /**
     * @Route("/", name="contact.master_index")
     * @Template
     * @Acl(
     *     id="contact.master_view",
     *     type="entity",
     *     class="ContactBundle:Master",
     *     permission="VIEW"
     * )
     */
    public function indexAction()
    {

        /*$em = $this->getDoctrine()->getManager();
        $cars = $em->getRepository('ContactBundle:Master')->findAll();
        echo "<pre>";
        
        \Doctrine\Common\Util\Debug::dump($cars);
        echo "</pre>";*/
        /*return array(
            'cars' => $cars,
        );
*/
        return array('gridName' => 'master-grid');
    }
     /**
     * @Route("/create", name="contact.master_create")
     * @Template("ContactBundle:Master:update.html.twig")
     * @Acl(
     *     id="contact.master_create",
     *     type="entity",
     *     class="ContactBundle:Master",
     *     permission="CREATE"
     * )
     */
    public function createAction(Request $request)
    {
        return $this->update(new Master(), $request);
    }

    /**
     * @Route("/update/{id}", name="contact.master_update", requirements={"id":"\d+"}, defaults={"id":0})
     * @Template()
     * @Acl(
     *     id="contact.master_update",
     *     type="entity",
     *     class="ContactBundle:Master",
     *     permission="EDIT"
     * )
     */
    public function updateAction(Master $vehicle, Request $request)
    {
        return $this->update($vehicle, $request);
    }

    private function update(Master $vehicle, Request $request)
    {

        $form = $this->get('form.factory')->create('contact_master', $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicle);
            $entityManager->flush();

            return $this->get('oro_ui.router')->redirectAfterSave(
                array(
                    'route' => 'contact.master_update',
                    'parameters' => array('id' => $vehicle->getId()),
                ),
                array('route' => 'contact.master_index'),
                $vehicle
            );
        }

        return array(
            'entity' => $vehicle,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/{id}", name="contact.master_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("contact.master_view")
     */
    public function viewAction(Master $vehicle)
    {
        return array('master' => $vehicle,'entity' => $vehicle);
    }
}