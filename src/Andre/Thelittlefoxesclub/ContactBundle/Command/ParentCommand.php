<?php 
 namespace Andre\Thelittlefoxesclub\ContactBundle\Command;

    use Oro\Bundle\CronBundle\Command\CronCommandInterface;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\DependencyInjection\ContainerAwareInterface;
    use Symfony\Component\DependencyInjection\ContainerAwareTrait;

    class ParentCommand extends Command implements CronCommandInterface,ContainerAwareInterface
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
            $this->setName('oro:cron:andre:parent');
            $this->setDescription('Command to fetch from Magento API');
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {





            $q = $this->container->get('doctrine.orm.entity_manager')->createQuery('select m from Oro\Bundle\MagentoBundle\Entity\Customer m where m.group = 6');

            $iterableResult = $q->iterate();
            $OroToMagentoIds = array();
            $MagentoToOro = array();
            while (($row = $iterableResult->next()) !== false) {
                $magentoParentId = (int) $row[0]->getOriginId();
                $accountId = $row[0]->getAccount()->getId();
                if($magentoParentId && $accountId) { echo $magentoParentId."=".$accountId."\n"; }
                $OroToMagentoIds[$accountId] = $magentoParentId;
                $MagentoToOro[$magentoParentId] = $accountId;
            }
           // print_r($OroToMagentoIds);
           // print_r($MagentoToOro);

           // \Doctrine\Common\Util\Debug::dump(count($MagentoToOro));
           // \Doctrine\Common\Util\Debug::dump(count($OroToMagentoIds));
           // die("\n----\n");

            $remoteJSON = file_get_contents('http://thelittl.nextmp.net/index.php/bsitcoro/index/allcustomer');
            $remoteArray = json_decode($remoteJSON);
            $spouseArray  = array();
            foreach ($remoteArray as $key => $value) {
                $spouseArray[$value[0]->id] = $value[0]->spousename;
            }



            $allMagetnoToOro = array();
            $batchSize = 20;
            $i = 0;
            $q = $this->container->get('doctrine.orm.entity_manager')
            ->createQuery('select m from Oro\Bundle\AccountBundle\Entity\Account m');
            $iterableResult = $q->iterate();
            foreach ($iterableResult as $row) {
                $user = $row[0];

                if($user->getMagentoid())
                {
                    $allMagetnoToOro[$user->getMagentoid()] = $user->getId();
                }

                if(isset($OroToMagentoIds[$user->getId()]))
                {
                    $user->setMagentoid($OroToMagentoIds[$user->getId()]);
                    $user->setIsParent(1);
                    $spousename = isset($spouseArray[$OroToMagentoIds[$user->getId()]])?$spouseArray[$OroToMagentoIds[$user->getId()]]:"";
                    $user->setSpouse($spousename);

                    $this->container->get('doctrine.orm.entity_manager')->persist($user);        
                    if (($i % $batchSize) === 0) {
                        $this->container->get('doctrine.orm.entity_manager')->flush();
                        $this->container->get('doctrine.orm.entity_manager')->clear(); 
                    }        
                }
                ++$i;
            }
            $this->container->get('doctrine.orm.entity_manager')->flush(); 
            $this->container->get('doctrine.orm.entity_manager')->clear();
            print_r(count($allMagetnoToOro));


        }
    }