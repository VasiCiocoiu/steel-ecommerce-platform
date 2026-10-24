<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $receiver = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $messageContent = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $sendAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getReceiver(): ?string
    {
        return $this->receiver;
    }

    public function setReceiver(int $receiver): static
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getMessageContent(): ?string
    {
        return $this->messageContent;
    }

    public function setMessageContent(string $messageContent): static
    {
        $this->messageContent = $messageContent;

        return $this;
    }

    public function getSendAt(): ?\DateTimeImmutable
    {
        return $this->sendAt;
    }

    public function setSendAt(\DateTimeImmutable $sendAt): static
    {
        $this->sendAt = $sendAt;

        return $this;
    }

    // TO DO
    /**
     * @return Collection<int, User>
     */
}
