<?php

namespace Andre\Thelittlefoxesclub\ContactBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Authperson
 *
 * @ORM\Table(name="andre_authperson")
 * @ORM\Entity(repositoryClass="Andre\Thelittlefoxesclub\ContactBundle\Repository\AuthpersonRepository")
 */
class Authperson
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @var Oro\Bundle\MagentoBundle\Entity\Account
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\AccountBundle\Entity\Account")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $accountId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="oro_id", type="integer", nullable=true)
     */
    private $oroId;
    /**
     * @var int
     *
     * @ORM\Column(name="magento_id", type="integer", nullable=true)
     */
    private $magId;

    /**
     * @var int
     *
     * @ORM\Column(name="magento_parent_id", type="integer", nullable=true)
     */
    private $magParentId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Authperson
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set accountId
     *
     * @param \Oro\Bundle\AccountBundle\Entity\Account $accountId
     *
     * @return Authperson
     */
    public function setAccountId(\Oro\Bundle\AccountBundle\Entity\Account $accountId = null)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get accountId
     *
     * @return \Oro\Bundle\AccountBundle\Entity\Account
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set oroId
     *
     * @param integer $oroId
     *
     * @return Authperson
     */
    public function setOroId($oroId)
    {
        $this->oroId = $oroId;

        return $this;
    }

    /**
     * Get oroId
     *
     * @return integer
     */
    public function getOroId()
    {
        return $this->oroId;
    }

    /**
     * Set magId
     *
     * @param integer $magId
     *
     * @return Authperson
     */
    public function setMagId($magId)
    {
        $this->magId = $magId;

        return $this;
    }

    /**
     * Get magId
     *
     * @return integer
     */
    public function getMagId()
    {
        return $this->magId;
    }

    /**
     * Set magParentId
     *
     * @param integer $magParentId
     *
     * @return Authperson
     */
    public function setMagParentId($magParentId)
    {
        $this->magParentId = $magParentId;

        return $this;
    }

    /**
     * Get magParentId
     *
     * @return integer
     */
    public function getMagParentId()
    {
        return $this->magParentId;
    }
}
