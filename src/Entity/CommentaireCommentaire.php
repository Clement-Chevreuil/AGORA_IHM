<?php

namespace App\Entity;

use App\Repository\CommentaireCommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireCommentaireRepository::class)
 */
class CommentaireCommentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=commentaire::class, inversedBy="commentaireCommentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commentaire_first;

    /**
     * @ORM\ManyToOne(targetEntity=commentaire::class, inversedBy="commentaireCommentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commentaire_second;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaireFirst(): ?commentaire
    {
        return $this->commentaire_first;
    }

    public function setCommentaireFirst(?commentaire $commentaire_first): self
    {
        $this->commentaire_first = $commentaire_first;

        return $this;
    }

    public function getCommentaireSecond(): ?commentaire
    {
        return $this->commentaire_second;
    }

    public function setCommentaireSecond(?commentaire $commentaire_second): self
    {
        $this->commentaire_second = $commentaire_second;

        return $this;
    }
}
