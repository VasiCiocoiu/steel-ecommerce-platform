<?php

namespace App\Entity;

use App\Repository\OrderLineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderLineRepository::class)]
class OrderLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?float $cutLength = null;

    #[ORM\Column]
    private ?float $cutPrice = null;

    #[ORM\Column(nullable: true)]
    private ?float $discount = null;

    /**
     * @var Collection<int, ItemManager>
     */
    #[ORM\OneToMany(targetEntity: ItemManager::class, mappedBy: 'orderLine')]
    private Collection $itemManagers;

    /**
     * @var Collection<int, Dimension>
     */
    #[ORM\ManyToMany(targetEntity: Dimension::class, inversedBy: 'orderLines')]
    private Collection $dimension;

    public function __construct()
    {
        $this->itemManagers = new ArrayCollection();
        $this->dimension = new ArrayCollection();
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

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

    public function getCutPrice(): ?float
    {
        return $this->cutPrice;
    }

    public function setCutPrice(float $cutPrice): static
    {
        $this->cutPrice = $cutPrice;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return Collection<int, ItemManager>
     */
    public function getItemManagers(): Collection
    {
        return $this->itemManagers;
    }

    public function addItemManager(ItemManager $itemManager): static
    {
        // $itemManager = new ItemManager();
        // $itemManager->setId($itemManagerId);

        if (!$this->itemManagers->contains($itemManager)) {
            $this->itemManagers->add($itemManager);
            $itemManager->setOrderLine($this);
        }

        return $this;
    }

    public function removeItemManager(ItemManager $itemManager): static
    {
        if ($this->itemManagers->removeElement($itemManager)) {
            // set the owning side to null (unless already changed)
            if ($itemManager->getOrderLine() === $this) {
                $itemManager->setOrderLine(null);
            }
        }

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
}
