<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $siret = null;

    #[ORM\Column(length: 50)]
    private ?string $nameCompany = null;


    #[ORM\ManyToOne(inversedBy: 'company')]
    private ?Address $address = null;

    #[ORM\ManyToOne(inversedBy: 'Companys')]
    private ?User $user = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getSiret(): ?int
    {
        return $this->siret;
    }

    public function setSiret(int $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getNameCompany(): ?string
    {
        return $this->nameCompany;
    }

    public function setNameCompany(string $nameCompany): static
    {
        $this->nameCompany = $nameCompany;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $client): static
    {
        $this->user = $client;
        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }
}
