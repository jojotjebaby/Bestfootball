<?php

namespace BF\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description: Media
 * @ORM\Entity
 * @ORM\Table()
 */
class Media {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $originalImage;

    /**
     * @ORM\Column(name="created",type="date")
     */
    protected $created;


    public function __construct() {
        $this->created = new \Datetime();
    }


    public function getUploadRootDir()
    {
        // absolute path to your directory where images must be saved
        return '/var/www/bestfootball.fr/shared/web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        return 'uploads/img';
    }

    public function getAbsolutePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir().'/'.$this->image;
    }

    public function getWebPath()
    {
        return null === $this->image ? null : '/'.$this->getUploadDir().'/'.$this->image;
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Media
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /* Set file
     *
     * @param $file
     * @return Media
     */

    public function setFile($file) {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file.
     *
     * @return $file
     */
    public function getFile() {
        return $this->file;
    }


    /**
     * Set image
     *
     * @param string $image
     *
     * @return Media
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Media
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
     * Set path
     *
     * @param string $path
     *
     * @return Media
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set originalImage
     *
     * @param string $originalImage
     *
     * @return Media
     */
    public function setOriginalImage($originalImage)
    {
        $this->originalImage = $originalImage;

        return $this;
    }

    /**
     * Get originalImage
     *
     * @return string
     */
    public function getOriginalImage()
    {
        return $this->originalImage;
    }
}
