<?php 
 namespace Andre\Thelittlefoxesclub\ContactBundle\Command;

    use Oro\Bundle\CronBundle\Command\CronCommandInterface;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\DependencyInjection\ContainerAwareInterface;
    use Symfony\Component\DependencyInjection\ContainerAwareTrait;

    class DemoCommand extends Command implements CronCommandInterface,ContainerAwareInterface
    {
        use ContainerAwareTrait;
        public function getDefaultDefinition()
        {
            return '5 0 * * *';
        }

        public function isCronEnabled()
        {
            // check some pre-conditions
            return $condition ? true : false;
        }
        /**
        * @deprecated Since 2.0.3. Will be removed in 2.1. Must be refactored at BAP-13973
        *
        * @return bool
        */
        public function isActive()
        {
            return true;
        }

        protected function configure()
        {
            $this->setName('oro:cron:andre:demo');
            $this->setDescription('Command to fetch from Magento API');
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {

            //die("------");


/*For OROCRM2*/
    $username = 'shanky';
    $apiUserKey = '1450d751a7f24b06f0d02bf82488ba30b1745cd1';
    $userSalt = ''; // Will be removed in version 1.0 of OroCRM
    $apiUrl = 'http://orocrm2.example.com/app_dev.php';
    $apiPassword = 'Shanky123!'; 



$q = $this->container->get('doctrine.orm.entity_manager')->createQuery('select m from Oro\Bundle\MagentoBundle\Entity\Customer m where m.group = 6');
//$numUpdated = $q->execute();
$iterableResult = $q->iterate();
$OroToMagentoIds = array();
$MagentoToOro = array();
while (($row = $iterableResult->next()) !== false) {
    $magentoParentId = (int) $row[0]->getOriginId();
    $accountId = $row[0]->getAccount()->getId();
    $OroToMagentoIds[$accountId] = $magentoParentId;
    $MagentoToOro[$magentoParentId] = $accountId;
//  \Doctrine\Common\Util\Debug::dump();  
}

$remoteJSON = file_get_contents('http://thelittl.nextmp.net/index.php/bsitcoro/index/allcustomer');
$remoteArray = json_decode($remoteJSON);

if(count($remoteArray) <= 0){
    die('No Data found ...');
}


            $childrenAccountId = array();            
            $q = $this->container->get('doctrine.orm.entity_manager')
            ->createQuery('select m from Oro\Bundle\AccountBundle\Entity\Account m where m.is_parent = 0');
            $iterableResult = $q->iterate();
            foreach ($iterableResult as $row) {
                $user = $row[0];
                //echo $user->getMagentoid();
                $childrenAccountId[$user->getMagentoid()] = $user->getId();
            }
            
          //  die("\nChildren account Id count: ".json_encode($childrenAccountId)."\n");



//print_r($remoteArray);
$childrenCounter = 0;
$authorisedCounter = 0;
$arrayChildren = array();
$arrayAuthorised = array();


foreach ($remoteArray as $key => $value) {
    if(isset($MagentoToOro[$value[0]->id]))
    {
        //echo count(is_array($value[0]->authorised_person));
        if(!empty($value[0]->authorised_person))
        {
           // echo "====";
            foreach ($value[0]->authorised_person as $key2 => $value2) {

                $arrayAuthorised[$authorisedCounter] = $value2;
                $arrayAuthorised[$authorisedCounter]->parentMagentoId = $value[0]->id;
                $arrayAuthorised[$authorisedCounter]->parentAccountId = $MagentoToOro[$value[0]->id];
                $authorisedCounter++;
            }
        }
        if(is_array($value[0]->children) && count($value[0]->children) > 0)
        {
            foreach ($value[0]->children as $key1 => $value1) {
                $arrayChildren[$childrenCounter] = $value1;
               
                $arrayChildren[$childrenCounter]->childMagentoId = $value1->id;
                 $arrayChildren[$childrenCounter]->childAccountId = isset($childrenAccountId[$value1->id])?$childrenAccountId[$value1->id]:0;
                $arrayChildren[$childrenCounter]->parentMagentoId = $value[0]->id;
                $arrayChildren[$childrenCounter]->parentAccountId = $MagentoToOro[$value[0]->id];
                $childrenCounter++;               
            }
        }
    }
}

/*print_r($arrayAuthorised);
die("==END==");
*/




$testing[0] = $arrayChildren[0];
$testing[1] = $arrayChildren[1];

foreach ($testing as $key => $value) {
   // if($key > 2){ break; }

    $api = new \Andre\Thelittlefoxesclub\ContactBundle\Controller\Oroapi($username, $apiPassword, $apiUserKey, $apiUrl,'');
$postArr = new \stdClass();
    if((int)$value->childAccountId === 0)
    {
        echo "Inserted\n";
        $postArr = new \stdClass();
        $postArr->data = new \stdClass();
        $postArr->data->type= "accounts";
        //$postArr->data->id= "62";
        $postArr->data->attributes = new \stdClass();
        $postArr->data->attributes->name = $value->first_name." ".$value->surname;
        $postArr->data->attributes->is_parent = "0";
        $postArr->data->attributes->magentoid = (string) $value->childMagentoId ; 
        
        $postArr->data->relationships = new \stdClass();
        $postArr->data->relationships->owner = new \stdClass();
        $postArr->data->relationships->owner->data = new \stdClass();
        $postArr->data->relationships->owner->data->type= "users";
        $postArr->data->relationships->owner->data->id= "1";

        $postArr->data->relationships->parent = new \stdClass();
        $postArr->data->relationships->parent->data = new \stdClass();
        $postArr->data->relationships->parent->data->type= "accounts";
        $postArr->data->relationships->parent->data->id=(string) $value->parentAccountId;

       //print_r($api->post_api_account($postArr));
    }
    else
    {
      echo "Updated\n";  
    }
    /*
    else
    {
        echo "Updated\n";
        $postArr = new \stdClass();
        $postArr->data = new \stdClass();
        $postArr->data->type= "accounts";
        $postArr->data->id= (string) $value->childAccountId;
        $postArr->data->attributes = new \stdClass();
        $postArr->data->attributes->name = $value->first_name." -".$value->surname;
        $postArr->data->attributes->magentoid = (string) $value->childMagentoId; 
        $postArr->data->attributes->is_parent = "0";

        $postArr->data->relationships = new \stdClass();
        $postArr->data->relationships->owner = new \stdClass();
        $postArr->data->relationships->owner->data = new \stdClass();
        $postArr->data->relationships->owner->data->type= "users";
        $postArr->data->relationships->owner->data->id= "1";

        $postArr->data->relationships->parent = new \stdClass();
        $postArr->data->relationships->parent->data = new \stdClass();
        $postArr->data->relationships->parent->data->type= "accounts";
        $postArr->data->relationships->parent->data->id=(string) $value->parentAccountId;
        // to update
        // print_r($api->patch_api_account($postArr,$value->childAccountId));
    }  
    */

    $arr[] = $postArr;  
}




    $q = $this->container->get('doctrine.orm.entity_manager')->createQuery('delete from Andre\Thelittlefoxesclub\ContactBundle\Entity\Authperson m');
    $numDeleted = $q->execute();



    $batchSize = 20;
    $i = 0;
    foreach ($arrayAuthorised as $key => $value) {

    $user = new \Andre\Thelittlefoxesclub\ContactBundle\Entity\Authperson;
    $user->setName($value->name);
    $a =   $this->container->get('doctrine.orm.entity_manager')
                                ->getRepository('OroAccountBundle:Account')
                                ->findOneBy(['id' => $value->parentAccountId]);

    $user->setAccountId($a);
    $user->setMagId($value->id);
    $user->setMagParentId($value->parentMagentoId);
    $user->setOroId($value->parentAccountId);

    $this->container->get('doctrine.orm.entity_manager')->persist($user); 
    if (($i % $batchSize) === 0) {
                $this->container->get('doctrine.orm.entity_manager')->flush();
                $this->container->get('doctrine.orm.entity_manager')->clear(); 
            }  
        ++$i;
        //\Doctrine\Common\Util\Debug::dump($user);
        
        
    }
    $this->container->get('doctrine.orm.entity_manager')->flush(); 
    $this->container->get('doctrine.orm.entity_manager')->clear();






        }
    }