<?php

namespace BF\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
    * @ORM\OneToOne(targetEntity="BF\SiteBundle\Entity\Picture", cascade={"persist"})
    */
    private $picture;

    /**
    * @ORM\OneToMany(targetEntity="BF\SiteBundle\Entity\Video", mappedBy="user")
    */
    private $videos; // Notez le « s », une annonce est liée à plusieurs candidatures

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    //we add the collumns we want for the user

    /**
    * @ORM\Column(name="name", type="string", length=255, nullable=true)
    */
    private $name;

    /**
    * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
    */
    private $firstname;

    /**
    * @ORM\Column(name="birthday", type="datetime", nullable=true)
    */
    private $birthday;

    /**
    * @ORM\Column(name="city", type="string", length=255, nullable=true)
    */
    private $city;

    /**
    * @ORM\Column(name="country", type="string", length=255, nullable=true)
    */
    private $country;

    /**
    * @ORM\Column(name="gender", type="string", length=10, nullable=true)
    */
    private $gender;

    /**
    * @ORM\Column(name="footballClub", type="string", length=255, nullable=true)
    */
    private $footballClub;

    /**
    * @ORM\Column(name="fieldPosition", type="string", length=255, nullable=true)
    */
    private $fieldPosition;

    /**
    * @ORM\Column(name="foot", type="string", length=255, nullable=true)
    */
    private $foot;

    /**
    * @ORM\Column(name="points", type="integer", length=100, nullable=true)
    */
    private $points;

    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;
    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set footballClub
     *
     * @param string $footballClub
     *
     * @return User
     */
    public function setFootballClub($footballClub)
    {
        $this->footballClub = $footballClub;

        return $this;
    }

    /**
     * Get footballClub
     *
     * @return string
     */
    public function getFootballClub()
    {
        return $this->footballClub;
    }

    /**
     * Set fieldPosition
     *
     * @param string $fieldPosition
     *
     * @return User
     */
    public function setFieldPosition($fieldPosition)
    {
        $this->fieldPosition = $fieldPosition;

        return $this;
    }

    /**
     * Get fieldPosition
     *
     * @return string
     */
    public function getFieldPosition()
    {
        return $this->fieldPosition;
    }

    /**
     * Set foot
     *
     * @param string $foot
     *
     * @return User
     */
    public function setFoot($foot)
    {
        $this->foot = $foot;

        return $this;
    }

    /**
     * Get foot
     *
     * @return string
     */
    public function getFoot()
    {
        return $this->foot;
    }

    /**
     * Add video
     *
     * @param \EZ\SiteBundle\Entity\Video $video
     *
     * @return User
     */
    public function addVideo(\BF\SiteBundle\Entity\Video $video)
    {
        $this->videos[] = $video;

        return $this;
    }

    /**
     * Remove video
     *
     * @param \EZ\SiteBundle\Entity\Video $video
     */
    public function removeVideo(\BF\SiteBundle\Entity\Video $video)
    {
        $this->videos->removeElement($video);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return User
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set picture
     *
     * @param \BF\SiteBundle\Entity\Picture $picture
     *
     * @return User
     */
    public function setPicture(\BF\SiteBundle\Entity\Picture $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return \BF\SiteBundle\Entity\Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * Set facebookAccessToken
     *
     * @param string $facebookAccessToken
     *
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebook_access_token = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebookAccessToken
     *
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }
}
