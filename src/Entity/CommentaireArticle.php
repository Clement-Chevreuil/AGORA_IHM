<?php

namespace App\Entity;

use App\Repository\CommentaireArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireArticleRepository::class)
 */
class CommentaireArticle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=commentaire::class, inversedBy="commentaireArticles")
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=article::class, inversedBy="commentaireArticles")
     */
    private $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?commentaire
    {
        return $this->commentaire;
    }

    public function setCommentaire(?commentaire $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getArticle(): ?article
    {
        return $this->article;
    }

    public function setArticle(?article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
