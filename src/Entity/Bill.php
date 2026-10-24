<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BillRepository::class)]
#[ApiResource]
class Bill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $billNumber = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $bilDate = null;

    #[ORM\Column]
    private ?float $tva = null;

    #[ORM\Column]
    private ?float $totalHTC = null;

    #[ORM\Column(length: 50)]
    private ?string $userName = null;

    // #[ORM\Column(length: 50)]
    // private ?string $typeUser = null;

    #[ORM\Column]
    private ?int $siret = null;

    #[ORM\Column(length: 50)]
    private ?string $CompanyName = null;



    public function __construct()
    {
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

    public function getBillNumber(): ?int
    {
        return $this->billNumber;
    }

    public function setBillNumber(int $billNumber): static
    {
        $this->billNumber = $billNumber;

        return $this;
    }

    public function getBilDate(): ?\DateTimeImmutable
    {
        return $this->bilDate;
    }

    public function setBilDate(\DateTimeImmutable $bilDate): static
    {
        $this->bilDate = $bilDate;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    public function getTotalHTC(): ?float
    {
        return $this->totalHTC;
    }

    public function setTotalHTC(float $totalHTC): static
    {
        $this->totalHTC = $totalHTC;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): static
    {
        $this->userName = $userName;

        return $this;
    }

    // public function getTypeUser(): ?string
    // {
    //     return $this->typeUser;
    // }

    // public function setTypeUser(string $typeUser): static
    // {
    //     $this->typeUser = $typeUser;

    //     return $this;
    // }

    public function getSiret(): ?int
    {
        return $this->siret;
    }

    public function setSiret(int $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->CompanyName;
    }

    public function setCompanyName(string $CompanyName): static
    {
        $this->CompanyName = $CompanyName;

        return $this;
    }
}
