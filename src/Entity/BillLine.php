<?php

namespace App\Entity;

use App\Repository\BillLineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BillLineRepository::class)]
class BillLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $unitPrice = null;

    #[ORM\Column(length: 255)]
    private ?string $productName = null;

    #[ORM\Column]
    private ?float $cutLength = null;

    #[ORM\Column]
    private ?int $productQuantity = null;

    #[ORM\Column]
    private ?float $discount = null;

    #[ORM\Column]
    private ?float $cutPrice = null;

    /**
     * @var Collection<int, Dimension>
     */
    #[ORM\ManyToMany(targetEntity: Dimension::class, inversedBy: 'billLines')]
    private Collection $dimension;

    /**
     * @var Collection<int, ItemManager>
     */
    #[ORM\OneToMany(targetEntity: ItemManager::class, mappedBy: 'billLine')]
    private Collection $itemManager;

    public function __construct()
    {
        $this->dimension = new ArrayCollection();
        $this->itemManager = new ArrayCollection();
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

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): static
    {
        $this->productName = $productName;

        return $this;
    }

    public function getCutLength(): ?float
    {
        return $this->cutLength;
    }

    public function setCutLength(float $cutLength): static
    {
        $this->cutLength = $cutLength;

        return $this;
    }

    public function getProductQuantity(): ?int
    {
        return $this->productQuantity;
    }

    public function setProductQuantity(int $productQuantity): static
    {
        $this->productQuantity = $productQuantity;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getCutPrice(): ?float
    {
        return $this->cutPrice;
    }

    public function setCutPrice(float $cutPrice): static
    {
        $this->cutPrice = $cutPrice;

        return $this;
    }

    /**
     * @return Collection<int, Dimension>
     */
    public function getDimension(): Collection
    {
        return $this->dimension;
    }

    public function addDimension(Dimension $dimension): static
    {
        if (!$this->dimension->contains($dimension)) {
            $this->dimension->add($dimension);
        }

        return $this;
    }

    public function removeDimension(Dimension $dimension): static
    {
        $this->dimension->removeElement($dimension);

        return $this;
    }

    /**
     * @return Collection<int, ItemManager>
     */
    public function getItemManager(): Collection
    {
        return $this->itemManager;
    }

    public function addItemManager(ItemManager $itemManager): static
    {
        if (!$this->itemManager->contains($itemManager)) {
            $this->itemManager->add($itemManager);
            $itemManager->setBillLine($this);
        }

        return $this;
    }

    public function removeItemManager(ItemManager $itemManager): static
    {
        if ($this->itemManager->removeElement($itemManager)) {
            // set the owning side to null (unless already changed)
            if ($itemManager->getBillLine() === $this) {
                $itemManager->setBillLine(null);
            }
        }

        return $this;
    }
}
