<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messagesSend")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userSend;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messagesReceive")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userReceive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getUserSend(): ?User
    {
        return $this->userSend;
    }

    public function setUserSend(?User $userSend): self
    {
        $this->userSend = $userSend;

        return $this;
    }

    public function getUserReceive(): ?User
    {
        return $this->userReceive;
    }

    public function setUserReceive(?User $userReceive): self
    {
        $this->userReceive = $userReceive;

        return $this;
    }
}
