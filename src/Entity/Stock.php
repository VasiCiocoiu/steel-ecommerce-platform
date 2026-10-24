<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
#[ApiResource]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $stockQuantity = null;

    #[ORM\Column]
    private ?float $stockLength = null;

    /**
     * @var Collection<int, Dimension>
     */
    #[ORM\OneToMany(targetEntity: Dimension::class, mappedBy: 'stock')]
    private Collection $dimensions;

    /**
     * @var Collection<int, Provider>
     */
    #[ORM\OneToMany(targetEntity: Provider::class, mappedBy: 'stock')]
    private Collection $provider;

    /**
     * @var Collection<int, Warehouse>
     */
    #[ORM\OneToMany(targetEntity: Warehouse::class, mappedBy: 'stock')]
    private Collection $warehouse;

    public function __construct()
    {
        $this->dimensions = new ArrayCollection();
        $this->provider = new ArrayCollection();
        $this->warehouse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStockQuantity(): ?int
    {
        return $this->stockQuantity;
    }

    public function setStockQuantity(int $stockQuantity): static
    {
        $this->stockQuantity = $stockQuantity;

        return $this;
    }

    public function getStockLength(): ?float
    {
        return $this->stockLength;
    }

    public function setStockLength(float $stockLength): static
    {
        $this->stockLength = $stockLength;

        return $this;
    }

    /**
     * @return Collection<int, Dimension>
     */
    public function getDimensions(): Collection
    {
        return $this->dimensions;
    }

    public function addDimension(Dimension $dimension): static
    {
        if (!$this->dimensions->contains($dimension)) {
            $this->dimensions->add($dimension);
            $dimension->setStock($this);
        }

        return $this;
    }

    public function removeDimension(Dimension $dimension): static
    {
        if ($this->dimensions->removeElement($dimension)) {
            // set the owning side to null (unless already changed)
            if ($dimension->getStock() === $this) {
                $dimension->setStock(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Provider>
     */
    public function getProvider(): Collection
    {
        return $this->provider;
    }

    public function addProvider(Provider $provider): static
    {
        if (!$this->provider->contains($provider)) {
            $this->provider->add($provider);
            $provider->setStock($this);
        }

        return $this;
    }

    public function removeProvider(Provider $provider): static
    {
        if ($this->provider->removeElement($provider)) {
            // set the owning side to null (unless already changed)
            if ($provider->getStock() === $this) {
                $provider->setStock(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Warehouse>
     */
    public function getWarehouse(): Collection
    {
        return $this->warehouse;
    }

    public function addWarehouse(Warehouse $warehouse): static
    {
        if (!$this->warehouse->contains($warehouse)) {
            $this->warehouse->add($warehouse);
            $warehouse->setStock($this);
        }

        return $this;
    }

    public function removeWarehouse(Warehouse $warehouse): static
    {
        if ($this->warehouse->removeElement($warehouse)) {
            // set the owning side to null (unless already changed)
            if ($warehouse->getStock() === $this) {
                $warehouse->setStock(null);
            }
        }

        return $this;
    }
}
