<?php 
namespace Andre\Thelittlefoxesclub\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Andre\Thelittlefoxesclub\ContactBundle\Entity\Holiday;
use Symfony\Component\HttpFoundation\Request;

use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

/**
 * @Route("/holiday")
 */
class HolidayController extends Controller
{
    /**
     * @Route("/", name="contact.holiday_index")
     * @Template
     * @Acl(
     *     id="contact.holiday_view",
     *     type="entity",
     *     class="ContactBundle:Holiday",
     *     permission="VIEW"
     * )
     */
    public function indexAction()
    {

        /*$em = $this->getDoctrine()->getManager();
        $cars = $em->getRepository('ContactBundle:Holiday')->findAll();
        echo "<pre>";
        
        \Doctrine\Common\Util\Debug::dump($cars);
        echo "</pre>";*/
        /*return array(
            'cars' => $cars,
        );
*/
        return array('gridName' => 'holiday-grid');
    }
     /**
     * @Route("/create", name="contact.holiday_create")
     * @Template("ContactBundle:Holiday:update.html.twig")
     * @Acl(
     *     id="contact.holiday_create",
     *     type="entity",
     *     class="ContactBundle:Holiday",
     *     permission="CREATE"
     * )
     */
    public function createAction(Request $request)
    {
        return $this->update(new Holiday(), $request);
    }

    /**
     * @Route("/update/{id}", name="contact.holiday_update", requirements={"id":"\d+"}, defaults={"id":0})
     * @Template()
     * @Acl(
     *     id="contact.holiday_update",
     *     type="entity",
     *     class="ContactBundle:Holiday",
     *     permission="EDIT"
     * )
     */
    public function updateAction(Holiday $vehicle, Request $request)
    {
        return $this->update($vehicle, $request);
    }

    private function update(Holiday $vehicle, Request $request)
    {

        $form = $this->get('form.factory')->create('contact_holiday', $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicle);
            $entityManager->flush();

            return $this->get('oro_ui.router')->redirectAfterSave(
                array(
                    'route' => 'contact.holiday_update',
                    'parameters' => array('id' => $vehicle->getId()),
                ),
                array('route' => 'contact.holiday_index'),
                $vehicle
            );
        }

        return array(
            'entity' => $vehicle,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/{id}", name="contact.holiday_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("contact.holiday_view")
     */
    public function viewAction(Holiday $vehicle)
    {
        return array('holiday' => $vehicle,'entity' => $vehicle);
    }
}