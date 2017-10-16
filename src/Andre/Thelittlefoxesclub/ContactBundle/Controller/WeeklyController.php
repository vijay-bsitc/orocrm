<?php 
namespace Andre\Thelittlefoxesclub\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Andre\Thelittlefoxesclub\ContactBundle\Entity\Weekly;
use Symfony\Component\HttpFoundation\Request;

use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

/**
 * @Route("/weekly")
 */
class WeeklyController extends Controller
{
    /**
     * @Route("/", name="contact.weekly_index")
     * @Template
     * @Acl(
     *     id="contact.weekly_view",
     *     type="entity",
     *     class="ContactBundle:Weekly",
     *     permission="VIEW"
     * )
     */
    public function indexAction()
    {

        /*$em = $this->getDoctrine()->getManager();
        $cars = $em->getRepository('ContactBundle:Weekly')->findAll();
        echo "<pre>";
        
        \Doctrine\Common\Util\Debug::dump($cars);
       
       
        \Doctrine\Common\Util\Debug::dump($cars[0]->getChildren()[0]->getAccountId()->getName());
        echo "</pre>";
      die("ads");*/

        return array('gridName' => 'weekly-grid');
    }
    /**
     * @Route(
     *        "/helloworld/{name}",
     *        name="contact.widget.tab",
     * )
     * @Template
     */
    public function helloworldWidgetAction($name)
    {
       // die("Adf");
        return ['name'=>$name,'children'=>['adsasdf','asdasdf']];
    }

     /**
     * @Route("/create", name="contact.weekly_create")
     * @Template("ContactBundle:Weekly:update.html.twig")
     * @Acl(
     *     id="contact.weekly_create",
     *     type="entity",
     *     class="ContactBundle:Weekly",
     *     permission="CREATE"
     * )
     */
    public function createAction(Request $request)
    {
        return $this->update(new Weekly(), $request);
    }

    /**
     * @Route("/update/{id}", name="contact.weekly_update", requirements={"id":"\d+"}, defaults={"id":0})
     * @Template()
     * @Acl(
     *     id="contact.weekly_update",
     *     type="entity",
     *     class="ContactBundle:Weekly",
     *     permission="EDIT"
     * )
     */
    public function updateAction(Weekly $vehicle, Request $request)
    {
        return $this->update($vehicle, $request);
    }

    private function update(Weekly $vehicle, Request $request)
    {

        $form = $this->get('form.factory')->create('contact_weekly', $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicle);
            $entityManager->flush();

            return $this->get('oro_ui.router')->redirectAfterSave(
                array(
                    'route' => 'contact.weekly_update',
                    'parameters' => array('id' => $vehicle->getId()),
                ),
                array('route' => 'contact.weekly_index'),
                $vehicle
            );
        }

        return array(
            'entity' => $vehicle,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/{id}", name="contact.weekly_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("contact.weekly_view")
     */
    public function viewAction(Weekly $vehicle)
    {


        

        $em = $this->getDoctrine()->getManager();
        $cars = $em->getRepository('ContactBundle:Weekly')->getNumberofWeeks($vehicle);

        return array('weekly' => $vehicle,'entity' => $vehicle,"c"=>$cars);
    }
}