<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\ItemManagerEnum;
use App\Repository\ItemManagerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\TypeItemManager;
use App\Enum\QuoteStatus;

#[ORM\Entity(repositoryClass: ItemManagerRepository::class)]
#[ApiResource]
class ItemManager
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', enumType: TypeItemManager::class)]
    private TypeItemManager $typeItemManager;

    #[ORM\Column(type: 'string', enumType: QuoteStatus::class)]
    private QuoteStatus $quoteStatus;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'itemManager')]
    private Collection $users;



    #[ORM\ManyToOne(inversedBy: 'itemManagers')]
    private ?OrderLine $orderLine = null;

    #[ORM\ManyToOne(inversedBy: 'itemManager')]
    private ?BillLine $billLine = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * Get the value of typeItemManager
     */
    public function getTypeItemManager(): TypeItemManager
    {
        return $this->typeItemManager;
    }

    /**
     * Set the value of typeItemManager
     */
    public function setTypeItemManager(string $typeItemManager): self
    {
        if (!in_array($typeItemManager, TypeItemManager::toArray())) {
            throw new \InvalidArgumentException('Invalid value');
        }
        $this->typeItemManager = TypeItemManager::fromValue($typeItemManager);

        return $this;
    }

    /**
     * Get the value of quoteStatus
     */
    public function getQuoteStatus(): QuoteStatus
    {
        return $this->quoteStatus;
    }

    /**
     * Set the value of quoteStatus
     */

    public function setQuoteStatus(string $quoteStatus): self
    {
        if (!in_array($quoteStatus, QuoteStatus::toArray())) {
            throw new \InvalidArgumentException('Invalid value');
        }
        $this->quoteStatus = QuoteStatus::fromValue($quoteStatus);

        return $this;
    }


    public function getOrderLine(): ?OrderLine
    {
        return $this->orderLine;
    }

    public function setOrderLine(?OrderLine $orderLine): static
    {
        $this->orderLine = $orderLine;

        return $this;
    }

    public function getBillLine(): ?BillLine
    {
        return $this->billLine;
    }

    public function setBillLine(?BillLine $billLine): static
    {
        $this->billLine = $billLine;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users ?? new ArrayCollection();
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setItemManager($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getItemManager() === $this) {
                $user->setItemManager(null);
            }
        }

        return $this;
    }
}
