<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DimensionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;

#[ORM\Entity(repositoryClass: DimensionRepository::class)]
#[ApiResource]
class Dimension
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, BillLine>
     */
    #[ORM\ManyToMany(targetEntity: BillLine::class, mappedBy: 'dimension')]
    private ?Collection $billLines = null;

    /**
     * @var Collection<int, OrderLine>
     */
    #[ORM\ManyToMany(targetEntity: OrderLine::class, mappedBy: 'dimension')]
    private ?Collection $orderLines = null;

    #[ORM\Column(nullable: true)]
    private ?int $sizeA = null;

    #[ORM\Column(nullable: true)]
    private ?int $sizeB = null;

    #[ORM\Column(nullable: true)]
    private ?int $sizeC = null;

    #[ORM\Column(nullable: true)]
    private ?int $sizeD = null;

    #[ORM\Column(nullable: true)]
    private ?int $sizeE = null;

    #[ORM\Column]
    private ?float $unitPrice = null;

    #[ORM\Column]
    private ?float $linearMass = null;

    #[ORM\ManyToOne(inversedBy: 'dimensions')]
    private ?Stock $stock = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\Column]
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'dimension')]
    private Collection $product;

    public function __construct()
    {
        $this->billLines = new ArrayCollection();
        $this->orderLines = new ArrayCollection();
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection<int, BillLine>
     */
    public function getBillLines(): Collection
    {
        return $this->billLines;
    }

    public function addBillLine(BillLine $billLine): static
    {
        if (!$this->billLines->contains($billLine)) {
            $this->billLines->add($billLine);
            $billLine->addDimension($this);
        }

        return $this;
    }

    public function removeBillLine(BillLine $billLine): static
    {
        if ($this->billLines->removeElement($billLine)) {
            $billLine->removeDimension($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderLine>
     */
    public function getOrderLines(): Collection
    {
        return $this->orderLines;
    }

    public function addOrderLine(OrderLine $orderLine): static
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines->add($orderLine);
            $orderLine->addDimension($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): static
    {
        if ($this->orderLines->removeElement($orderLine)) {
            $orderLine->removeDimension($this);
        }

        return $this;
    }

    public function getSizeA(): ?int
    {
        return $this->sizeA;
    }

    public function setSizeA(int $sizeA): static
    {
        $this->sizeA = $sizeA;

        return $this;
    }

    public function getSizeB(): ?int
    {
        return $this->sizeB;
    }

    public function setSizeB(int $sizeB): static
    {
        $this->sizeB = $sizeB;

        return $this;
    }

    public function getSizeC(): ?int
    {
        return $this->sizeC;
    }

    public function setSizeC(?int $sizeC): static
    {
        $this->sizeC = $sizeC;

        return $this;
    }

    public function getSizeD(): ?int
    {
        return $this->sizeD;
    }

    public function setSizeD(?int $sizeD): static
    {
        $this->sizeD = $sizeD;

        return $this;
    }

    public function getSizeE(): ?int
    {
        return $this->sizeE;
    }

    public function setSizeE(?int $sizeE): static
    {
        $this->sizeE = $sizeE;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getLinearMass(): ?float
    {
        return $this->linearMass;
    }

    public function setLinearMass(float $linearMass): static
    {
        $this->linearMass = $linearMass;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->product->contains($product)) {
            $this->product->add($product);
            $product->setDimension($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->product->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getDimension() === $this) {
                $product->setDimension(null);
            }
        }

        return $this;
    }
}
