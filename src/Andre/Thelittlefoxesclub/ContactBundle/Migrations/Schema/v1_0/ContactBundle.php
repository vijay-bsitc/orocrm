<?php
namespace Andre\Thelittlefoxesclub\ContactBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtension;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtensionAwareInterface;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class ContactBundle implements Migration,ExtendExtensionAwareInterface
{
    protected $extendExtension;

    public function setExtendExtension(ExtendExtension $extendExtension)
    {

        $this->extendExtension = $extendExtension;
    }

    /**
     * @inheritdoc
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        //$this->table_extend_oro_account($schema,$queries);       
        $this->table_andre_authperson($schema,$queries);       
        $this->table_andre_accountextended($schema,$queries);
        $this->table_andre_holiday($schema,$queries);
        $this->table_andre_master($schema,$queries);
        $this->table_andre_weekly($schema,$queries);
        $this->table_andre_weeklyjchildren($schema,$queries);

    }
    public function table_extend_oro_account(Schema $schema, QueryBag $queries){
        $table = $schema->createTable('orocrm_account');
        $table->addColumn(
            'is_parent',
            'text',
            [
                'oro_options' => [
                    'extend'   => ['owner' => ExtendScope::OWNER_CUSTOM],
                    'datagrid' => ['is_visible' => DatagridScope::IS_VISIBLE_FALSE],
                    'merge'    => ['display' => true],
                ]
            ]
        );
        $table->addColumn(
            'spouse',
            'string',
            [
                'length' => 255,
                'oro_options' => [
                    'extend'   => ['owner' => ExtendScope::OWNER_CUSTOM],
                    'datagrid' => ['is_visible' => DatagridScope::IS_VISIBLE_FALSE],
                    'merge'    => ['display' => true],
                ]
            ]
        );
        $table->addColumn(
            'magentoid',
            'integer',
            [
                'oro_options' => [
                    'extend'   => ['owner' => ExtendScope::OWNER_CUSTOM],
                    'datagrid' => ['is_visible' => DatagridScope::IS_VISIBLE_FALSE],
                    'merge'    => ['display' => true],
                ]
            ]
        );

         $this->extendExtension->addManyToOneRelation(
            $schema,
            $table,
            'parent',
            'orocrm_account',
            'id',
            [
                'extend' => ['owner' => ExtendScope::OWNER_CUSTOM]
            ]
        );
    }
    public function table_andre_authperson(Schema $schema, QueryBag $queries){
        $table = $schema->createTable('andre_authperson');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('account_id', 'integer', []);
        $table->addColumn('oro_id', 'integer', []);
        $table->addColumn('magento_id', 'integer', []);
        $table->addColumn('magento_parent_id', 'integer', []);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->setPrimaryKey(['id']);

        /*entity manytoone defined */
        $table->addForeignKeyConstraint(
            $schema->getTable('orocrm_account'),
            ['account_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );        
    }
    public function table_andre_accountextended(Schema $schema, QueryBag $queries){
        $table = $schema->createTable('andre_accountextended');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('account_id', 'integer', []);
        $table->addColumn('email', 'string', ['length' => 255]);
        $table->addColumn('dob', 'datetime', []);
        $table->addColumn('gender', 'integer', []);
        $table->addColumn('altmobile', 'string', ['length' => 255]);
        $table->addColumn('cmobile', 'string', ['length' => 255]);
        $table->addColumn('school', 'string', ['length' => 255]);
        $table->addColumn('medical_condition_medication', 'integer', []);
        $table->addColumn('medical_condition_text', 'string', ['length' => 255]);
        $table->setPrimaryKey(['id']);

        /*entity manytoone defined */
        $table->addForeignKeyConstraint(
            $schema->getTable('orocrm_account'),
            ['account_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );  
    }
    public function table_andre_holiday(Schema $schema, QueryBag $queries){
        $table = $schema->createTable('andre_holiday');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->setPrimaryKey(['id']);      
    }
    public function table_andre_master(Schema $schema, QueryBag $queries){
        $table = $schema->createTable('andre_master');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->setPrimaryKey(['id']);      
    }
    public function table_andre_weekly(Schema $schema, QueryBag $queries){
        $table = $schema->createTable('andre_weekly');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('class_sku', 'string', ['length' => 255]);
        $table->addColumn('class_term', 'string', ['length' => 255]);
        $table->addColumn('class_area', 'string', ['length' => 255]);
        $table->addColumn('class_venue', 'string', ['length' => 255]);
        $table->addColumn('class_type', 'string', ['length' => 255]);
        $table->addColumn('class_day', 'string', ['length' => 255]);
        $table->addColumn('class_time', 'string', ['length' => 255]);
        $table->addColumn('class_duration', 'string', ['length' => 255]);
        $table->addColumn('class_age_group', 'string', ['length' => 255]);
        $table->addColumn('class_sport', 'string', ['length' => 255]);
        $table->addColumn('class_gender', 'string', ['length' => 255]);
        $table->addColumn('class_active', 'string', ['length' => 255]);
        $table->addColumn('class_start_time', 'string', ['length' => 255]);
        $table->addColumn('class_end_time', 'string', ['length' => 255]);
        $table->addColumn('class_start_day', 'date', []);
        $table->setPrimaryKey(['id']);
    }
    public function table_andre_weeklyjchildren(Schema $schema, QueryBag $queries){
        $table = $schema->createTable('andre_weeklyjchildren');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('account_id', 'integer', []);
        $table->addColumn('weekly_id', 'integer', []);
        $table->setPrimaryKey(['id']);

        /*entity manytoone defined */
        $table->addForeignKeyConstraint(
            $schema->getTable('andre_weekly'),
            ['weekly_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );   
        $table->addForeignKeyConstraint(
            $schema->getTable('orocrm_account'),
            ['account_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );       
    }
}