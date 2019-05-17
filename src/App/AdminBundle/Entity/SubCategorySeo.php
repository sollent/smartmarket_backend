<?php

namespace App\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SubCategorySeo
 * @package App\AdminBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="sub_category_seo")
 */
class SubCategorySeo
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var SubCategory
     * @ORM\OneToOne(targetEntity="App\AdminBundle\Entity\SubCategory", inversedBy="seoInformation")
     * @ORM\JoinColumn(name="sub_category_id", referencedColumnName="id")
     */
    private $subCategory;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return SubCategorySeo
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return SubCategory
     */
    public function getSubCategory(): ?SubCategory
    {
        return $this->subCategory;
    }

    /**
     * @param SubCategory $subCategory
     * @return SubCategorySeo
     */
    public function setSubCategory(SubCategory $subCategory): SubCategorySeo
    {
        $this->subCategory = $subCategory;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return SubCategorySeo
     */
    public function setTitle(string $title): SubCategorySeo
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return SubCategorySeo
     */
    public function setDescription(string $description): SubCategorySeo
    {
        $this->description = $description;
        return $this;
    }
}