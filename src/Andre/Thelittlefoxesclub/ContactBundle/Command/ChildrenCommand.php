<?php 
 namespace Andre\Thelittlefoxesclub\ContactBundle\Command;

    use Oro\Bundle\CronBundle\Command\CronCommandInterface;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\DependencyInjection\ContainerAwareInterface;
    use Symfony\Component\DependencyInjection\ContainerAwareTrait;

    use Symfony\Component\Console\Input\InputOption;
    use Oro\Component\Log\OutputLogger;

    use Andre\Thelittlefoxesclub\ContactBundle\Controller\CommandLineConfig;

    class ChildrenCommand extends Command implements CronCommandInterface,ContainerAwareInterface
    {
        use ContainerAwareTrait;


        public function getDefaultDefinition()
        {
            return '0 0 1 Oct *';
        }

        public function isCronEnabled()
        {
            echo "-------------";
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
            return false;
        }

        protected function configure()
        {
            $this->setName('oro:cron:andre:children');
            $this->setDescription('Command to fetch from Magento API');
        }

    protected function execute(InputInterface $input, OutputInterface $output)
    {




        /*For OROCRM2*/
        $username    = CommandLineConfig::$USERNAME;
        $apiUserKey  = CommandLineConfig::$API_KEY;
        $userSalt    = ''; // Will be removed in version 1.0 of OroCRM
        $apiUrl      = CommandLineConfig::$API_URL;
        $apiPassword = CommandLineConfig::$PASSWORD;
        

        die("TEST MODE");

        $remoteJSON = @file_get_contents('http://sun286/littlefoxesclub/index.php/bsitcoro/index/getallchildren/date/2016-10-28%2000:00:00');
        if(!$remoteJSON){
            $logger->info('No data found.');
        }
        $remoteArray = json_decode($remoteJSON);

        if(is_array($remoteArray) && count($remoteArray) > 0)
        {

            $api = new \Andre\Thelittlefoxesclub\ContactBundle\Controller\Oroapi($username, $apiPassword, $apiUserKey, $apiUrl,'');

            $batchSize = 20;
            $i = 0;

             $childrenAccountId = array();            
            $q = $this->container->get('doctrine.orm.entity_manager')
            ->createQuery('select m from Oro\Bundle\AccountBundle\Entity\Account m where m.is_parent = 0');
            $iterableResult = $q->iterate();
            foreach ($iterableResult as $row) {
                $user = $row[0];
                //echo $user->getMagentoid();
                $childrenAccountId[$user->getMagentoid()] = $user->getId();
            }

            foreach ($remoteArray as $key => $value) 
            {
               

                if(isset($childrenAccountId[$value->id]))
                {
                    $account =   $this->container->get('doctrine.orm.entity_manager')
                                ->getRepository('OroAccountBundle:Account')
                                ->findOneBy(['id' => $childrenAccountId[$value->id]]);
                }
                else
                {

                    $postArr = new \stdClass();
                    $postArr->data = new \stdClass();
                    $postArr->data->type= "accounts";
                    //$postArr->data->id= "62";
                    $postArr->data->attributes = new \stdClass();
                    $postArr->data->attributes->name = $value->first_name." ".$value->surname;
                    $postArr->data->attributes->is_parent = "0";
                    $postArr->data->attributes->magentoid = (string) $value->id ; 
                    
                    $postArr->data->relationships = new \stdClass();
                    $postArr->data->relationships->owner = new \stdClass();
                    $postArr->data->relationships->owner->data = new \stdClass();
                    $postArr->data->relationships->owner->data->type= "users";
                    $postArr->data->relationships->owner->data->id= "1";

                    $postArr->data->relationships->parent = new \stdClass();
                    $postArr->data->relationships->parent->data = new \stdClass();
                    $postArr->data->relationships->parent->data->type= "accounts";
                    $postArr->data->relationships->parent->data->id=(string) $value->customer_id;

                    $response = $api->post_api_account($postArr);
                    if(isset($response->data->id))
                    {
                        $account =   $this->container->get('doctrine.orm.entity_manager')
                                ->getRepository('OroAccountBundle:Account')
                                ->findOneBy(['id' => $response->data->id]);
                    }
                    
                }

                


                if($account)
                {
                    $accountextented =   $this->container->get('doctrine.orm.entity_manager')
                    ->getRepository('ContactBundle:Accountextended')
                    ->findOneBy(['accountId' => $account->getId()]);

                    if(!$accountextented)
                    {
                        echo "Insert";
                        $accountextented = new \Andre\Thelittlefoxesclub\ContactBundle\Entity\Accountextended;
                    }


                    $date = new \DateTime(date("Y-m-d",strtotime($value->dob)));

                    $accountextented->setAccountId($account);
                    $accountextented->setMedicalConditionMedicationText($value->medical_condition_medication_text);
                    $accountextented->setMedicalConditionMedication($value->medical_condition_medication);
                    $accountextented->setSchool($value->school_nursery);
                    $accountextented->setDob($date);
                    $accountextented->setGender($value->gender);

                    $this->container->get('doctrine.orm.entity_manager')->persist($accountextented); 
                    if (($i % $batchSize) === 0) {
                        $this->container->get('doctrine.orm.entity_manager')->flush();
                        $this->container->get('doctrine.orm.entity_manager')->clear(); 
                    }  
                    ++$i;
                }
            }
            $this->container->get('doctrine.orm.entity_manager')->flush(); 
            $this->container->get('doctrine.orm.entity_manager')->clear();
        }



    }
}