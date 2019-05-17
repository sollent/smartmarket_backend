<?php

namespace App\AdminBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductSeo
 * @package App\AdminBundle\Entity\Product
 * @ORM\Entity
 * @ORM\Table(name="product_seo")
 */
class ProductSeo
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Product\Product", inversedBy="seoInformation")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

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
     * @var string
     * @ORM\Column(name="images_alt", type="string", nullable=true)
     */
    private $imagesAlt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ProductSeo
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return ProductSeo
     */
    public function setProduct(Product $product): ProductSeo
    {
        $this->product = $product;
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
     * @return ProductSeo
     */
    public function setTitle(string $title): ProductSeo
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
     * @return ProductSeo
     */
    public function setDescription(string $description): ProductSeo
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getImagesAlt(): ?string
    {
        return $this->imagesAlt;
    }

    /**
     * @param string $imagesAlt
     * @return ProductSeo
     */
    public function setImagesAlt(string $imagesAlt): ProductSeo
    {
        $this->imagesAlt = $imagesAlt;
        return $this;
    }
}