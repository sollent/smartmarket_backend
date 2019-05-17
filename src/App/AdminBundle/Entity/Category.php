<?php

namespace App\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Category
 * @package App\AdminBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=100)
     */
    private $slug;

    /**
     * @var mixed
     * @ORM\OneToMany(targetEntity="App\AdminBundle\Entity\SubCategory", mappedBy="parentCategory")
     */
    private $subCategories;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->subCategories = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Category
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName(string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Category
     */
    public function setSlug(string $slug): Category
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubCategories()
    {
        return $this->subCategories;
    }

    /**
     * @param mixed $subCategories
     * @return Category
     */
    public function setSubCategories($subCategories)
    {
        $this->subCategories = $subCategories;
        return $this;
    }

}