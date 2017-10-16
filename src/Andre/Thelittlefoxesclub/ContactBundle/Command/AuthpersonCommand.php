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

    class AuthpersonCommand extends Command implements CronCommandInterface,ContainerAwareInterface
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
            $this->setName('oro:cron:andre:authperson');
            $this->addOption(
                'channel-id',
                'c',
                InputOption::VALUE_OPTIONAL,
                'If option exists sync will be performed for given channel id'
            );
            $this->setDescription('Command to fetch from Magento API');
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $logger    = new OutputLogger($output);
            // $integrationId = $input->getOption('channel-id');
            


            $remoteJSON = @file_get_contents('http://sun286/littlefoxesclub/index.php/bsitcoro/index/getallauthorisedperson/date/2016-11-24%2012:36:09');
            if(!$remoteJSON){
                $logger->info('No data found.');
            }
            $remoteArray = json_decode($remoteJSON);
            $batchSize = 20;
            $i = 0;
            foreach ($remoteArray as $key => $value) {

                $a =   $this->container->get('doctrine.orm.entity_manager')
                    ->getRepository('ContactBundle:Authperson')
                    ->findOneBy(['magId' => 55]);
                   
                    \Doctrine\Common\Util\Debug::dump($a);
                $a->setName($value->name);
                $this->container->get('doctrine.orm.entity_manager')->persist($a); 
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