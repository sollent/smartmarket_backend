<?php

namespace App\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class NextSubCategory
 * @package App\AdminBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="next_sub_category")
 */
class NextSubCategory
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var SubCategory
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\SubCategory", inversedBy="subCategories")
     * @ORM\JoinColumn(name="parent_category_id", referencedColumnName="id")
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return NextSubCategory
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return SubCategory
     */
    public function getParentCategory(): ?SubCategory
    {
        return $this->parentCategory;
    }

    /**
     * @param SubCategory $parentCategory
     * @return NextSubCategory
     */
    public function setParentCategory(SubCategory $parentCategory): NextSubCategory
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
     * @return NextSubCategory
     */
    public function setName(string $name): NextSubCategory
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
     * @return NextSubCategory
     */
    public function setSlug(string $slug): NextSubCategory
    {
        $this->slug = $slug;
        return $this;
    }

}