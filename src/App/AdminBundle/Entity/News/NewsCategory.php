<?php

namespace App\AdminBundle\Entity\News;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class NewsCategory
 * @package App\AdminBundle\Entity\News
 * @ORM\Entity
 * @ORM\Table(name="news_category")
 */
class NewsCategory
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @ORM\OneToMany(targetEntity="App\AdminBundle\Entity\News\NewsSubCategory", mappedBy="parentCategory")
     */
    private $subCategories;

    /**
     * NewsCategory constructor.
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
     * @return NewsCategory
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
     * @return NewsCategory
     */
    public function setName(string $name): NewsCategory
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
     * @return NewsCategory
     */
    public function setSlug(string $slug): NewsCategory
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
     * @return NewsCategory
     */
    public function setSubCategories($subCategories)
    {
        $this->subCategories = $subCategories;
        return $this;
    }
}