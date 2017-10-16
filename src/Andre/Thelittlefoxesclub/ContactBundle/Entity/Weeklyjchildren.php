<?php

namespace Andre\Thelittlefoxesclub\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Weeklyjchildren
 *
 * @ORM\Table(name="andre_weeklyjchildren")
 * @ORM\Entity(repositoryClass="Andre\Thelittlefoxesclub\ContactBundle\Repository\WeeklyjchildrenRepository")
 */
class Weeklyjchildren
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
     * @var Andre\Thelittlefoxesclub\ContactBundle\Entity\Weekly
     *
     * @ORM\ManyToOne(targetEntity="Andre\Thelittlefoxesclub\ContactBundle\Entity\Weekly")
     * @ORM\JoinColumn(name="weekly_id", referencedColumnName="id")
     */
    private $weeklyId;
    /**
     * @var Oro\Bundle\MagentoBundle\Entity\Account
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\AccountBundle\Entity\Account")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $accountId;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set weeklyId
     *
     * @param \Andre\Thelittlefoxesclub\ContactBundle\Entity\Weekly $weeklyId
     *
     * @return Weeklyjchildren
     */
    public function setWeeklyId(\Andre\Thelittlefoxesclub\ContactBundle\Entity\Weekly $weeklyId = null)
    {
        $this->weeklyId = $weeklyId;

        return $this;
    }

    /**
     * Get weeklyId
     *
     * @return \Andre\Thelittlefoxesclub\ContactBundle\Entity\Weekly
     */
    public function getWeeklyId()
    {
        return $this->weeklyId;
    }

    /**
     * Set accountId
     *
     * @param \Oro\Bundle\AccountBundle\Entity\Account $accountId
     *
     * @return Weeklyjchildren
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
}
