<?php
// src/Acme/Bundle/TaskBundle/EventListener/ParameterListener.php
namespace Andre\Thelittlefoxesclub\ContactBundle\EventListener;

use Doctrine\ORM\QueryBuilder;

use Oro\Bundle\DataGridBundle\Datasource\Orm\OrmDatasource;
use Oro\Bundle\DataGridBundle\Event\BuildAfter;

class ParameterListener
{
    protected $parameterName;
    protected $requestParameterName;

    public function __construct($parameterName, $requestParameterName = null)
    {
        $this->parameterName = $parameterName;
        $this->requestParameterName = $requestParameterName ? $requestParameterName : $this->parameterName;
    }

    public function onBuildAfter(BuildAfter $event)
    {


        $config = $event->getDatagrid()->getConfig();
        echo "<pre>";
       die(var_dump($config));
       
       $newPhoneFilter = $config->offsetGetByPath("[filters][columns][phone]");
       $newPhoneFilter['label'] = 'Clients Phones';
       $config->offsetAddToArrayByPath("[filters][columns][phone]", $newPhoneFilter);
       return;


        $datagrid   = $event->getDatagrid();
        $datasource = $datagrid->getDatasource();
        $parameters = $datagrid->getParameters();

        if ($datasource instanceof OrmDatasource) {
            /** @var QueryBuilder $queryBuilder */
            $queryBuilder = $datasource->getQueryBuilder();

            $queryBuilder->setParameter($this->parameterName, $parameters->get($this->requestParameterName));
        }
    }
}