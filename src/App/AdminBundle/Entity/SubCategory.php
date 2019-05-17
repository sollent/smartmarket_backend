<?php

namespace App\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SubCategory
 * @package App\AdminBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="sub_category")
 */
class SubCategory
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Category", inversedBy="subCategories")
     * @ORM\JoinColumn(name="parent_category_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parentCategory;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string")
     */
    private $slug;

    /**
     * @var mixed
     * @ORM\OneToMany(targetEntity="App\AdminBundle\Entity\NextSubCategory", mappedBy="parentCategory")
     */
    private $subCategories;

    /**
     * @var mixed
     * @ORM\OneToOne(targetEntity="App\AdminBundle\Entity\SubCategorySeo", mappedBy="subCategory")
     */
    private $seoInformation;

    /**
     * SubCategory constructor.
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
     * @return SubCategory
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Category
     */
    public function getParentCategory(): ?Category
    {
        return $this->parentCategory;
    }

    /**
     * @param Category $parentCategory
     * @return SubCategory
     */
    public function setParentCategory(Category $parentCategory): SubCategory
    {
        $this->parentCategory = $parentCategory;
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
     * @return SubCategory
     */
    public function setName(string $name): SubCategory
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
     * @return SubCategory
     */
    public function setSlug(string $slug): SubCategory
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
     * @return SubCategory
     */
    public function setSubCategories($subCategories)
    {
        $this->subCategories = $subCategories;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeoInformation()
    {
        return $this->seoInformation;
    }

    /**
     * @param mixed $seoInformation
     * @return SubCategory
     */
    public function setSeoInformation($seoInformation)
    {
        $this->seoInformation = $seoInformation;
        return $this;
    }
}