<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VisitorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitorRepository::class)]
#[ApiResource]
class Visitor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $tokenVisitor = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?ItemManager $itemManager = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTokenVisitor(): ?string
    {
        return $this->tokenVisitor;
    }

    public function setTokenVisitor(string $tokenVisitor): static
    {
        $this->tokenVisitor = $tokenVisitor;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getItemManager(): ?ItemManager
    {
        return $this->itemManager;
    }

    public function setItemManager(?ItemManager $itemManager): static
    {
        $this->itemManager = $itemManager;

        return $this;
    }
}
