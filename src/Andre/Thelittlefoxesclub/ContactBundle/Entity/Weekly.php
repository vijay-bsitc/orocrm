<?php

namespace Andre\Thelittlefoxesclub\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
/**
 * Weekly
 *
 * @ORM\Table(name="andre_weekly")
 * @ORM\Entity(repositoryClass="Andre\Thelittlefoxesclub\ContactBundle\Repository\WeeklyRepository")
 * @Config(
 *      defaultValues={
 *          "entity"={
 *              "icon"="fa-remove"
 *          }
 *      }
 * )
 */
class Weekly
{
    public function __construct()
    {
      $this->children = new ArrayCollection();
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="shanky"
     *          }
     *      }
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="class_sku", type="string", length=255, nullable=true)
     */
    private $csku;

    /**
     * @var string
     *
     * @ORM\Column(name="class_term", type="string", length=255, nullable=true)
     */
    private $cterm;

    /**
     * @var string
     *
     * @ORM\Column(name="class_area", type="string", length=255, nullable=true)
     */
    private $carea;
     /**
     * @var string
     *
     * @ORM\Column(name="class_venue", type="string", length=255, nullable=true)
     */
    private $cvenue;

    /**
     * @var string
     *
     * @ORM\Column(name="class_type", type="string", length=50, nullable=true)
     */
    private $ctype;
     /**
     * @var string
     *
     * @ORM\Column(name="class_day", type="string", length=20, nullable=true)
     */
    private $cday;


    /**
     * @var string
     *
     * @ORM\Column(name="class_time", type="string", length=100, nullable=true)
     */
    private $ctime;

    /**
     * @var string
     *
     * @ORM\Column(name="class_duration", type="string", length=20, nullable=true)
     */
    private $cduration;

     /**
     * @var string
     *
     * @ORM\Column(name="class_age_group", type="string", length=20, nullable=true)
     */
    private $cagegroup;

     /**
     * @var string
     *
     * @ORM\Column(name="class_sport", type="string", length=100, nullable=true)
     */
    private $csport;
    /**
     * @var string
     *
     * @ORM\Column(name="class_gender", type="string", length=20, nullable=true)
     */
    private $cgender;

    /**
     * @var string
     *
     * @ORM\Column(name="class_active", type="string", length=255, nullable=true)
     */
    private $cactive;

    /**
     * @var Weeklyjchildren[]|Collection
     *
     * @ORM\OneToMany(targetEntity="Andre\Thelittlefoxesclub\ContactBundle\Entity\Weeklyjchildren",
     *     mappedBy="weeklyId", cascade={"all"}, orphanRemoval=true
     * )
     */
    protected $children;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="class_start_day", type="date", nullable=true)
     */
     protected $cstartdate;

    /**
     * @var string
     *
     * @ORM\Column(name="class_start_time", type="string", length=255, nullable=true)
     */
    private $cstarttime;
    /**
     * @var string
     *
     * @ORM\Column(name="class_end_time", type="string", length=255, nullable=true)
     */
    private $cendtime;
    /**
     * @var text
     *
     * @ORM\Column(name="iframe_html", type="text", nullable=true)
     */
    private $ciframeHtml;
   

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
     * @return Weekly
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
     * Set csku
     *
     * @param string $csku
     *
     * @return Weekly
     */
    public function setCsku($csku)
    {
        $this->csku = $csku;

        return $this;
    }

    /**
     * Get csku
     *
     * @return string
     */
    public function getCsku()
    {
        return $this->csku;
    }

    /**
     * Set cterm
     *
     * @param string $cterm
     *
     * @return Weekly
     */
    public function setCterm($cterm)
    {
        $this->cterm = $cterm;

        return $this;
    }

    /**
     * Get cterm
     *
     * @return string
     */
    public function getCterm()
    {
        return $this->cterm;
    }

    /**
     * Set carea
     *
     * @param string $carea
     *
     * @return Weekly
     */
    public function setCarea($carea)
    {
        $this->carea = $carea;

        return $this;
    }

    /**
     * Get carea
     *
     * @return string
     */
    public function getCarea()
    {
        return $this->carea;
    }

    /**
     * Set cvenue
     *
     * @param string $cvenue
     *
     * @return Weekly
     */
    public function setCvenue($cvenue)
    {
        $this->cvenue = $cvenue;

        return $this;
    }

    /**
     * Get cvenue
     *
     * @return string
     */
    public function getCvenue()
    {
        return $this->cvenue;
    }

    /**
     * Set ctype
     *
     * @param string $ctype
     *
     * @return Weekly
     */
    public function setCtype($ctype)
    {
        $this->ctype = $ctype;

        return $this;
    }

    /**
     * Get ctype
     *
     * @return string
     */
    public function getCtype()
    {
        return $this->ctype;
    }

    /**
     * Set cday
     *
     * @param string $cday
     *
     * @return Weekly
     */
    public function setCday($cday)
    {
        $this->cday = $cday;

        return $this;
    }

    /**
     * Get cday
     *
     * @return string
     */
    public function getCday()
    {
        return $this->cday;
    }

    /**
     * Set ctime
     *
     * @param string $ctime
     *
     * @return Weekly
     */
    public function setCtime($ctime)
    {
        $this->ctime = $ctime;

        return $this;
    }

    /**
     * Get ctime
     *
     * @return string
     */
    public function getCtime()
    {
        return $this->ctime;
    }

    /**
     * Set cduration
     *
     * @param string $cduration
     *
     * @return Weekly
     */
    public function setCduration($cduration)
    {
        $this->cduration = $cduration;

        return $this;
    }

    /**
     * Get cduration
     *
     * @return string
     */
    public function getCduration()
    {
        return $this->cduration;
    }

    /**
     * Set cagegroup
     *
     * @param string $cagegroup
     *
     * @return Weekly
     */
    public function setCagegroup($cagegroup)
    {
        $this->cagegroup = $cagegroup;

        return $this;
    }

    /**
     * Get cagegroup
     *
     * @return string
     */
    public function getCagegroup()
    {
        return $this->cagegroup;
    }

    /**
     * Set csport
     *
     * @param string $csport
     *
     * @return Weekly
     */
    public function setCsport($csport)
    {
        $this->csport = $csport;

        return $this;
    }

    /**
     * Get csport
     *
     * @return string
     */
    public function getCsport()
    {
        return $this->csport;
    }

    /**
     * Set cgender
     *
     * @param string $cgender
     *
     * @return Weekly
     */
    public function setCgender($cgender)
    {
        $this->cgender = $cgender;

        return $this;
    }

    /**
     * Get cgender
     *
     * @return string
     */
    public function getCgender()
    {
        return $this->cgender;
    }

    /**
     * Set cactive
     *
     * @param string $cactive
     *
     * @return Weekly
     */
    public function setCactive($cactive)
    {
        $this->cactive = $cactive;

        return $this;
    }

    /**
     * Get cactive
     *
     * @return string
     */
    public function getCactive()
    {
        return $this->cactive;
    }

    /**
     * Add child
     *
     * @param \Andre\Thelittlefoxesclub\ContactBundle\Entity\Weeklyjchildren $child
     *
     * @return Weekly
     */
    public function addChild(\Andre\Thelittlefoxesclub\ContactBundle\Entity\Weeklyjchildren $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Andre\Thelittlefoxesclub\ContactBundle\Entity\Weeklyjchildren $child
     */
    public function removeChild(\Andre\Thelittlefoxesclub\ContactBundle\Entity\Weeklyjchildren $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }
    

    /**
     * Set cstartdate
     *
     * @param \DateTime $cstartdate
     *
     * @return Weekly
     */
    public function setCstartdate($cstartdate)
    {
        $this->cstartdate = $cstartdate;

        return $this;
    }

    /**
     * Get cstartdate
     *
     * @return \DateTime
     */
    public function getCstartdate()
    {
        return $this->cstartdate;
    }

    /**
     * Set cstarttime
     *
     * @param string $cstarttime
     *
     * @return Weekly
     */
    public function setCstarttime($cstarttime)
    {
        $this->cstarttime = $cstarttime;

        return $this;
    }

    /**
     * Get cstarttime
     *
     * @return string
     */
    public function getCstarttime()
    {
        return $this->cstarttime;
    }

    /**
     * Set cendtime
     *
     * @param string $cendtime
     *
     * @return Weekly
     */
    public function setCendtime($cendtime)
    {
        $this->cendtime = $cendtime;

        return $this;
    }

    /**
     * Get cendtime
     *
     * @return string
     */
    public function getCendtime()
    {
        return $this->cendtime;
    }

    /**
     * Set ciframeHtml
     *
     * @param string $ciframeHtml
     *
     * @return Weekly
     */
    public function setCiframeHtml($ciframeHtml)
    {
        $this->ciframeHtml = $ciframeHtml;

        return $this;
    }

    /**
     * Get ciframeHtml
     *
     * @return string
     */
    public function getCiframeHtml()
    {
        return $this->ciframeHtml;
    }
}
