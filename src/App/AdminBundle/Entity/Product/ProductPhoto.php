<?php

namespace App\AdminBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ProductPhoto
 * @package App\AdminBundle\Entity\Product
 * @ORM\Entity
 * @ORM\Table(name="product_photo")
 */
class ProductPhoto
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", length=255)
     * @Assert\Image()
     * @Assert\NotBlank(message="Please, upload the images")
     */
    private $image;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="App\AdminBundle\Entity\Product\Product", inversedBy="photos")
     * @ORM\JoinColumn(name="product", referencedColumnName="id")
     */
    private $product;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ProductPhoto
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return ProductPhoto
     */
    public function setTitle(string $title): ProductPhoto
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return ProductPhoto
     */
    public function setImage(string $image): ProductPhoto
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return ProductPhoto
     */
    public function setProduct(Product $product): ProductPhoto
    {
        $this->product = $product;
        return $this;
    }

}