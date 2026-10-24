<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Controller\CurrentController;
use ApiPlatform\Action\NotFoundAction;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
// #[ApiResource(operations: [
//     new GetCollection()
// ],
// itemOperations: [
//     'get' =>[
//         'controller' => NotFoundAction::class,
//         'openapi_context' => ['summary' => 'hidden'],
//         'read' => false,
//         'output' => false
//     ]
//     ],

//         normalisation: ['groups'=>['read:User']] 

// )]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read::User')]
    private ?int $id = null;

    #[Groups(['read:User'])]
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    private ?string $phoneNumber = null;

    /**
     * @var Collection<int, Company>
     */
    #[ORM\OneToMany(targetEntity: Company::class, mappedBy: 'client')]
    private Collection $Companys;

    #[ORM\ManyToOne(inversedBy: 'idClient')]
    private ?Bill $bill = null;

    /**
     * @var Collection<int, Address>
     */
    #[ORM\OneToMany(targetEntity: Address::class, mappedBy: 'client')]
    private Collection $address;

    #[ORM\ManyToOne(inversedBy: 'clients')]
    private ?ItemManager $itemManager = null;

    public function __construct()
    {
        $this->Companys = new ArrayCollection();
        $this->address = new ArrayCollection();
    }

    /**
     * @var list<string> The user roles
     */
    #[Groups(['read:User'])]
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }
    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    /**
     * @return Collection<int, Company>
     */
    public function getCompanys(): Collection
    {
        return $this->Companys;
    }

    public function addCompany(Company $Company): static
    {
        if (!$this->Companys->contains($Company)) {
            $this->Companys->add($Company);
            $Company->setUser($this);
        }

        return $this;
    }

    public function removeCompany(Company $Company): static
    {
        if ($this->Companys->removeElement($Company)) {
            // set the owning side to null (unless already changed)
            if ($Company->getUser() === $this) {
                $Company->setUser(null);
            }
        }

        return $this;
    }
    public function getBill(): ?Bill
    {
        return $this->bill;
    }

    public function setBill(?Bill $bill): static
    {
        $this->bill = $bill;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(Address $address): static
    {
        if (!$this->address->contains($address)) {
            $this->address->add($address);
            $address->setUser($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): static
    {
        if ($this->address->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getUser() === $this) {
                $address->setUser(null);
            }
        }

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
