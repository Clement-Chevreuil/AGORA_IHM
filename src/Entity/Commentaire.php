<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
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
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=CommentaireCommentaire::class, mappedBy="comment_first")
     */
    private $commentaireCommentaires;

    /**
     * @ORM\OneToMany(targetEntity=CommentaireArticle::class, mappedBy="commentaire")
     */
    private $commentaireArticles;

    public function __construct()
    {
        $this->commentaireCommentaires = new ArrayCollection();
        $this->commentaireArticles = new ArrayCollection();
    }

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

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUserSend(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|CommentaireCommentaire[]
     */
    public function getCommentaireCommentaires(): Collection
    {
        return $this->commentaireCommentaires;
    }

    public function addCommentaireCommentaire(CommentaireCommentaire $commentaireCommentaire): self
    {
        if (!$this->commentaireCommentaires->contains($commentaireCommentaire)) {
            $this->commentaireCommentaires[] = $commentaireCommentaire;
            $commentaireCommentaire->setCommentFirst($this);
        }

        return $this;
    }

    public function removeCommentaireCommentaire(CommentaireCommentaire $commentaireCommentaire): self
    {
        if ($this->commentaireCommentaires->removeElement($commentaireCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaireCommentaire->getCommentFirst() === $this) {
                $commentaireCommentaire->setCommentFirst(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommentaireArticle[]
     */
    public function getCommentaireArticles(): Collection
    {
        return $this->commentaireArticles;
    }

    public function addCommentaireArticle(CommentaireArticle $commentaireArticle): self
    {
        if (!$this->commentaireArticles->contains($commentaireArticle)) {
            $this->commentaireArticles[] = $commentaireArticle;
            $commentaireArticle->setCommentaire($this);
        }

        return $this;
    }

    public function removeCommentaireArticle(CommentaireArticle $commentaireArticle): self
    {
        if ($this->commentaireArticles->removeElement($commentaireArticle)) {
            // set the owning side to null (unless already changed)
            if ($commentaireArticle->getCommentaire() === $this) {
                $commentaireArticle->setCommentaire(null);
            }
        }

        return $this;
    }
}
