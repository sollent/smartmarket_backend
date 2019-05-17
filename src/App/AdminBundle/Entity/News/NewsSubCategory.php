<?php

namespace App\AdminBundle\Entity\News;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class NewsSubCategory
 * @package App\AdminBundle\Entity\News
 * @ORM\Entity()
 * @ORM\Table(name="news_sub_category")
 */
class NewsSubCategory
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var NewsCategory
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\News\NewsCategory", inversedBy="subCategories")
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
     * @return NewsSubCategory
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return NewsCategory
     */
    public function getParentCategory(): ?NewsCategory
    {
        return $this->parentCategory;
    }

    /**
     * @param NewsCategory $parentCategory
     * @return NewsSubCategory
     */
    public function setParentCategory(NewsCategory $parentCategory): NewsSubCategory
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
     * @return NewsSubCategory
     */
    public function setName(string $name): NewsSubCategory
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
     * @return NewsSubCategory
     */
    public function setSlug(string $slug): NewsSubCategory
    {
        $this->slug = $slug;
        return $this;
    }

}