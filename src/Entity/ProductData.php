<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductDataRepository")
 */
class ProductData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer",length=255)
     */
    private $productDataId;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $productName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productDescription;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $productCode;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dtmAdded;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateDiscontinued;

    /**
     @ORM\Column(type="datetime", nullable=false)
   * @ORM\Version
     */
    private $timestamp;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $costGBP;

    /**
     * @ORM\Column(type="string", length=10, nullable=true,options={"unsigned":true, "default":"0"})
     */
    private $stock="0";

    public function getProductDataId(): ?int
    {
        return $this->productDataId;
    }

    public function getProductData(): ?int
    {
        return $this->productData;
    }

    public function setproductData(int $productData): self
    {
        $this->productData = $productData;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    public function setProductDescription(string $productDescription): self
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    public function getProductCode(): ?string
    {
        return $this->productCode;
    }

    public function setProductCode(string $productCode): self
    {
        $this->productCode = $productCode;

        return $this;
    }

    public function getDateAdded(): ?\DateTimeInterface
    {
        return $this->dateAdded;
    }

    public function setDateAdded(?\DateTimeInterface $dateAdded): self
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    public function getDateDiscontinued(): ?\DateTimeInterface
    {
        return $this->dateDiscontinued;
    }

    public function setDateDiscontinued(?\DateTimeInterface $dateDiscontinued): self
    {
        $this->dateDiscontinued = $dateDiscontinued;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getCostGBP(): ?string
    {
        return $this->costGBP;
    }

    public function setCostGBP(?string $costGBP): self
    {
        $this->costGBP = $costGBP;

        return $this;
    }

    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(?string $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
}
