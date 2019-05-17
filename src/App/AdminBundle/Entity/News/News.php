<?php

namespace App\AdminBundle\Entity\News;

use App\AdminBundle\Entity\Product\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class News
 * @package App\AdminBundle\Entity\News
 * @ORM\Entity
 * @ORM\Table(name="news")
 */
class News
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var NewsCategory
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\News\NewsCategory")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var NewsSubCategory
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\News\NewsSubCategory")
     * @ORM\JoinColumn(name="sub_category_id", referencedColumnName="id")
     */
    private $subCategory;

    /**
     * @var bool
     * @ORM\Column(name="is_overview", type="boolean")
     */
    private $isOverview = 0;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Product\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=true)
     */
    private $product;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="short_description", type="text")
     */
    private $shortDescription;

    /**
     * @var string
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var integer
     * @ORM\Column(name="likes", type="integer")
     */
    private $likes = 0;

    /**
     * @var string
     * @ORM\Column(name="preview_image", type="string", nullable=true)
     */
    private $previewImage;

    /**
     * @var boolean
     * @ORM\Column(name="is_main", type="boolean")
     */
    private $isMain = 0;

    /**
     * @var mixed
     * @ORM\OneToOne(targetEntity="App\AdminBundle\Entity\News\NewsSeo", mappedBy="news")
     */
    private $seoInformation;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return News
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return NewsCategory
     */
    public function getCategory(): ?NewsCategory
    {
        return $this->category;
    }

    /**
     * @param NewsCategory $category
     * @return News
     */
    public function setCategory(NewsCategory $category): News
    {
        $this->category = $category;
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
     * @return News
     */
    public function setTitle(string $title): News
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     * @return News
     */
    public function setShortDescription(string $shortDescription): News
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return News
     */
    public function setContent(string $content): News
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    /**
     * @param \DateTime $createdAt
     * @return News
     */
    public function setCreatedAt(\DateTime $createdAt): News
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getLikes(): ?int
    {
        return $this->likes;
    }

    /**
     * @param int $likes
     * @return News
     */
    public function setLikes(int $likes): News
    {
        $this->likes = $likes;
        return $this;
    }

    /**
     * @return string
     */
    public function getPreviewImage(): ?string
    {
        return $this->previewImage;
    }

    /**
     * @param string $previewImage
     * @return News
     */
    public function setPreviewImage(string $previewImage): News
    {
        $this->previewImage = $previewImage;
        return $this;
    }

    /**
     * @return NewsSubCategory
     */
    public function getSubCategory(): ?NewsSubCategory
    {
        return $this->subCategory;
    }

    /**
     * @param NewsSubCategory $subCategory
     * @return News
     */
    public function setSubCategory(NewsSubCategory $subCategory): News
    {
        $this->subCategory = $subCategory;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMain(): ?bool
    {
        return $this->isMain;
    }

    /**
     * @param bool $isMain
     * @return News
     */
    public function setIsMain(bool $isMain): News
    {
        $this->isMain = $isMain;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOverview(): ?bool
    {
        return $this->isOverview;
    }

    /**
     * @param bool $isOverview
     * @return News
     */
    public function setIsOverview(bool $isOverview): News
    {
        $this->isOverview = $isOverview;
        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return News
     */
    public function setProduct(?Product $product): News
    {
        $this->product = $product;
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
     * @return News
     */
    public function setSeoInformation($seoInformation)
    {
        $this->seoInformation = $seoInformation;
        return $this;
    }

}