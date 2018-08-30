<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class ProductData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer",length=255)
     */
    private $intProductDataId;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $strProductName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $strProductDesc;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $strProductCode;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dtmAdded;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dtmDescontinued;

    /**
     * @ORM\Column(type="datetime")
     */
    private $stmTimestamp;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $Cost_in_GBP;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Discontinued;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $stock;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntProductData(): ?int
    {
        return $this->intProductData;
    }

    public function setIntProductData(int $intProductData): self
    {
        $this->intProductData = $intProductData;

        return $this;
    }

    public function getIntProductDataId(): ?int
    {
        return $this->intProductDataId;
    }

    public function setIntProductDataId(int $intProductDataId): self
    {
        $this->intProductDataId = $intProductDataId;

        return $this;
    }

    public function getStrProductName(): ?string
    {
        return $this->strProductName;
    }

    public function setStrProductName(string $strProductName): self
    {
        $this->strProductName = $strProductName;

        return $this;
    }

    public function getStrProductDesc(): ?string
    {
        return $this->strProductDesc;
    }

    public function setStrProductDesc(string $strProductDesc): self
    {
        $this->strProductDesc = $strProductDesc;

        return $this;
    }

    public function getStrProductCode(): ?string
    {
        return $this->strProductCode;
    }

    public function setStrProductCode(string $strProductCode): self
    {
        $this->strProductCode = $strProductCode;

        return $this;
    }

    public function getDtmAdded(): ?\DateTimeInterface
    {
        return $this->dtmAdded;
    }

    public function setDtmAdded(?\DateTimeInterface $dtmAdded): self
    {
        $this->dtmAdded = $dtmAdded;

        return $this;
    }

    public function getDtmDescontinued(): ?\DateTimeInterface
    {
        return $this->dtmDescontinued;
    }

    public function setDtmDescontinued(?\DateTimeInterface $dtmDescontinued): self
    {
        $this->dtmDescontinued = $dtmDescontinued;

        return $this;
    }

    public function getStmTimestamp(): ?\DateTimeInterface
    {
        return $this->stmTimestamp;
    }

    public function setStmTimestamp(\DateTimeInterface $stmTimestamp): self
    {
        $this->stmTimestamp = $stmTimestamp;

        return $this;
    }

    public function getCostInGBP(): ?string
    {
        return $this->Cost_in_GBP;
    }

    public function setCostInGBP(?string $Cost_in_GBP): self
    {
        $this->Cost_in_GBP = $Cost_in_GBP;

        return $this;
    }

    public function getDiscontinued(): ?\DateTimeInterface
    {
        return $this->Discontinued;
    }

    public function setDiscontinued(?\DateTimeInterface $Discontinued): self
    {
        $this->Discontinued = $Discontinued;

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
