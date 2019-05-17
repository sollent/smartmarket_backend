<?php

namespace App\AdminBundle\Entity\Product;

use App\AdminBundle\Entity\Category;
use App\AdminBundle\Entity\SubCategory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * Class Product
 * @package App\AdminBundle\Entity\Product
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var SubCategory
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\SubCategory")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @MaxDepth(1)
     */
    private $category;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var integer
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var boolean
     * @ORM\Column(name="available", type="boolean")
     */
    private $available = true;

    /**
     * @var string
     * @ORM\Column(name="short_description", type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @var ProductColor
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Product\ProductColor")
     * @ORM\JoinColumn(name="product_color_id", referencedColumnName="id")
     */
    private $productColor;

    /**
     * @var ProductStatus
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Product\ProductStatus")
     * @ORM\JoinColumn(name="product_status_id", referencedColumnName="id")
     */
    private $productStatus;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var boolean
     * @ORM\Column(name="discount_status", type="boolean")
     */
    private $discountStatus = false;

    /**
     * @var integer
     * @ORM\Column(name="discount_percent_value", type="integer", nullable=true)
     */
    private $discountPercentValue;

    /**
     * @var string
     * @ORM\Column(name="preview_photo", type="string", nullable=true)
     */
    private $previewPhoto;

    /**
     * @ORM\OneToMany(targetEntity="App\AdminBundle\Entity\Product\ProductPhoto", mappedBy="product")
     * @MaxDepth(1)
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity="App\AdminBundle\Entity\Product\ProductCharacteristicSection", mappedBy="product")
     * @MaxDepth(1)
     */
    private $characteristics;

    /**
     * @var mixed
     * @ORM\OneToOne(targetEntity="App\AdminBundle\Entity\Product\ProductSeo", mappedBy="product")
     */
    private $seoInformation;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->photos = new ArrayCollection();
        $this->characteristics = new ArrayCollection();
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
     * @return Product
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return SubCategory
     */
    public function getCategory(): SubCategory
    {
        return $this->category;
    }

    /**
     * @param SubCategory $category
     * @return Product
     */
    public function setCategory(SubCategory $category): Product
    {
        $this->category = $category;
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
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Product
     */
    public function setPrice(int $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAvailable(): ?bool
    {
        return $this->available;
    }

    /**
     * @param bool $available
     * @return Product
     */
    public function setAvailable(bool $available): Product
    {
        $this->available = $available;
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
     * @return Product
     */
    public function setShortDescription(string $shortDescription): Product
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * @return ProductColor
     */
    public function getProductColor(): ?ProductColor
    {
        return $this->productColor;
    }

    /**
     * @param ProductColor $productColor
     * @return Product
     */
    public function setProductColor(ProductColor $productColor): Product
    {
        $this->productColor = $productColor;
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
     * @return Product
     */
    public function setCreatedAt(\DateTime $createdAt = null): Product
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDiscountStatus(): ?bool
    {
        return $this->discountStatus;
    }

    /**
     * @param bool $discountStatus
     * @return Product
     */
    public function setDiscountStatus(bool $discountStatus): Product
    {
        $this->discountStatus = $discountStatus;
        return $this;
    }

    /**
     * @return int
     */
    public function getDiscountPercentValue(): ?int
    {
        return $this->discountPercentValue;
    }

    /**
     * @param int $discountPercentValue
     * @return Product
     */
    public function setDiscountPercentValue(int $discountPercentValue): Product
    {
        $this->discountPercentValue = $discountPercentValue;
        return $this;
    }

    /**
     * @return string
     */
    public function getPreviewPhoto(): ?string
    {
        return $this->previewPhoto;
    }

    /**
     * @param string $previewPhoto
     * @return Product
     */
    public function setPreviewPhoto(string $previewPhoto): Product
    {
        $this->previewPhoto = $previewPhoto;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param mixed $photos
     * @return Product
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCharacteristics()
    {
        return $this->characteristics;
    }

    /**
     * @param mixed $characteristics
     * @return Product
     */
    public function setCharacteristics($characteristics)
    {
        $this->characteristics = $characteristics;
        return $this;
    }

    /**
     * @return ProductStatus
     */
    public function getProductStatus(): ?ProductStatus
    {
        return $this->productStatus;
    }

    /**
     * @param ProductStatus $productStatus
     * @return Product
     */
    public function setProductStatus(ProductStatus $productStatus): Product
    {
        $this->productStatus = $productStatus;
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
     * @return Product
     */
    public function setSeoInformation($seoInformation)
    {
        $this->seoInformation = $seoInformation;
        return $this;
    }

}