<?php

namespace Andre\Thelittlefoxesclub\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Accountextended
 *
 * @ORM\Table(name="andre_accountextended")
 * @ORM\Entity(repositoryClass="Andre\Thelittlefoxesclub\ContactBundle\Repository\AccountextendedRepository")
 */
class Accountextended
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dob", type="date", nullable=true)
     */
    private $dob;

    /**
     * @var int
     *
     * @ORM\Column(name="gender", type="smallint", nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="altmobile", type="string", length=20, nullable=true)
     */
    private $altmobile;

    /**
     * @var string
     *
     * @ORM\Column(name="cmobile", type="string", length=20, nullable=true)
     */
    private $cmobile;

    /**
     * @var string
     *
     * @ORM\Column(name="school", type="string", length=255, nullable=true)
     */
    private $school;

    /**
     * @var int
     *
     * @ORM\Column(name="medical_condition_medication", type="smallint", nullable=true)
     */
    private $medicalConditionMedication;

    /**
     * @var string
     *
     * @ORM\Column(name="medical_condition_text", type="text", nullable=true)
     */
    private $medicalConditionMedicationText;


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
     * Set email
     *
     * @param string $email
     *
     * @return Accountextended
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     *
     * @return Accountextended
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set gender
     *
     * @param integer $gender
     *
     * @return Accountextended
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set altmobile
     *
     * @param string $altmobile
     *
     * @return Accountextended
     */
    public function setAltmobile($altmobile)
    {
        $this->altmobile = $altmobile;

        return $this;
    }

    /**
     * Get altmobile
     *
     * @return string
     */
    public function getAltmobile()
    {
        return $this->altmobile;
    }

    /**
     * Set cmobile
     *
     * @param string $cmobile
     *
     * @return Accountextended
     */
    public function setCmobile($cmobile)
    {
        $this->cmobile = $cmobile;

        return $this;
    }

    /**
     * Get cmobile
     *
     * @return string
     */
    public function getCmobile()
    {
        return $this->cmobile;
    }

    /**
     * Set school
     *
     * @param string $school
     *
     * @return Accountextended
     */
    public function setSchool($school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return string
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set medicalConditionMedication
     *
     * @param integer $medicalConditionMedication
     *
     * @return Accountextended
     */
    public function setMedicalConditionMedication($medicalConditionMedication)
    {
        $this->medicalConditionMedication = $medicalConditionMedication;

        return $this;
    }

    /**
     * Get medicalConditionMedication
     *
     * @return int
     */
    public function getMedicalConditionMedication()
    {
        return $this->medicalConditionMedication;
    }

    /**
     * Set medicalConditionMedicationText
     *
     * @param string $medicalConditionMedicationText
     *
     * @return Accountextended
     */
    public function setMedicalConditionMedicationText($medicalConditionMedicationText)
    {
        $this->medicalConditionMedicationText = $medicalConditionMedicationText;

        return $this;
    }

    /**
     * Get medicalConditionMedicationText
     *
     * @return string
     */
    public function getMedicalConditionMedicationText()
    {
        return $this->medicalConditionMedicationText;
    }

    /**
     * Set accountId
     *
     * @param \Oro\Bundle\AccountBundle\Entity\Account $accountId
     *
     * @return Accountextended
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
