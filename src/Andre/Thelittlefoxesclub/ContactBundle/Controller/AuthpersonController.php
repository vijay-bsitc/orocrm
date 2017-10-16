<?php 
namespace Andre\Thelittlefoxesclub\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Andre\Thelittlefoxesclub\ContactBundle\Entity\Authperson;
use Symfony\Component\HttpFoundation\Request;

use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

/**
 * @Route("/authperson")
 */
class AuthpersonController extends Controller
{
    /**
     * @Route("/", name="contact.authperson_index")
     * @Template
     * @Acl(
     *     id="contact.authperson_view",
     *     type="entity",
     *     class="ContactBundle:Authperson",
     *     permission="VIEW"
     * )
     */
    public function indexAction()
    {

        /*$em = $this->getDoctrine()->getManager();
        $cars = $em->getRepository('ContactBundle:Authperson')->findAll();
        echo "<pre>";
        
        \Doctrine\Common\Util\Debug::dump($cars);
        echo "</pre>";*/
        /*return array(
            'cars' => $cars,
        );
*/
        return array('gridName' => 'authperson-grid');
    }
     /**
     * @Route("/create", name="contact.authperson_create")
     * @Template("ContactBundle:Authperson:update.html.twig")
     * @Acl(
     *     id="contact.authperson_create",
     *     type="entity",
     *     class="ContactBundle:Authperson",
     *     permission="CREATE"
     * )
     */
    public function createAction(Request $request)
    {
        return $this->update(new Authperson(), $request);
    }

    /**
     * @Route("/update/{id}", name="contact.authperson_update", requirements={"id":"\d+"}, defaults={"id":0})
     * @Template()
     * @Acl(
     *     id="contact.authperson_update",
     *     type="entity",
     *     class="ContactBundle:Authperson",
     *     permission="EDIT"
     * )
     */
    public function updateAction(Authperson $vehicle, Request $request)
    {
        return $this->update($vehicle, $request);
    }

    private function update(Authperson $vehicle, Request $request)
    {

        $form = $this->get('form.factory')->create('contact_authperson', $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicle);
            $entityManager->flush();

            return $this->get('oro_ui.router')->redirectAfterSave(
                array(
                    'route' => 'contact.authperson_update',
                    'parameters' => array('id' => $vehicle->getId()),
                ),
                array('route' => 'contact.authperson_index'),
                $vehicle
            );
        }

        return array(
            'entity' => $vehicle,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/{id}", name="contact.authperson_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("contact.authperson_view")
     */
    public function viewAction(Authperson $vehicle)
    {
        return array('authperson' => $vehicle,'entity' => $vehicle);
    }
}