<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=UserArticleInformations::class, mappedBy="article", orphanRemoval=true)
     */
    private $userArticleInformations;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text_position;

    /**
     * @ORM\OneToMany(targetEntity=ArticleTag::class, mappedBy="article", orphanRemoval=true)
     */
    private $articleTags;

    /**
     * @ORM\OneToMany(targetEntity=CommentaireArticle::class, mappedBy="article")
     */
    private $commentaireArticles;


    public function __construct()
    {
        $this->userArticleInformations = new ArrayCollection();
        $this->articleTags = new ArrayCollection();
        $this->commentaireArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }



    /**
     * @return Collection|UserArticleInformations[]
     */
    public function getUserArticleInformations(): Collection
    {
        return $this->userArticleInformations;
    }

    public function addUserArticleInformation(UserArticleInformations $userArticleInformation): self
    {
        if (!$this->userArticleInformations->contains($userArticleInformation)) {
            $this->userArticleInformations[] = $userArticleInformation;
            $userArticleInformation->setArticle($this);
        }

        return $this;
    }

    public function removeUserArticleInformation(UserArticleInformations $userArticleInformation): self
    {
        if ($this->userArticleInformations->removeElement($userArticleInformation)) {
            // set the owning side to null (unless already changed)
            if ($userArticleInformation->getArticle() === $this) {
                $userArticleInformation->setArticle(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getTextPosition(): ?string
    {
        return $this->text_position;
    }

    public function setTextPosition(string $text_position): self
    {
        $this->text_position = $text_position;

        return $this;
    }

    /**
     * @return Collection|ArticleTag[]
     */
    public function getArticleTags(): Collection
    {
        return $this->articleTags;
    }

    public function addArticleTag(ArticleTag $articleTag): self
    {
        if (!$this->articleTags->contains($articleTag)) {
            $this->articleTags[] = $articleTag;
            $articleTag->setArticle($this);
        }

        return $this;
    }

    public function removeArticleTag(ArticleTag $articleTag): self
    {
        if ($this->articleTags->removeElement($articleTag)) {
            // set the owning side to null (unless already changed)
            if ($articleTag->getArticle() === $this) {
                $articleTag->setArticle(null);
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
            $commentaireArticle->setArticle($this);
        }

        return $this;
    }

    public function removeCommentaireArticle(CommentaireArticle $commentaireArticle): self
    {
        if ($this->commentaireArticles->removeElement($commentaireArticle)) {
            // set the owning side to null (unless already changed)
            if ($commentaireArticle->getArticle() === $this) {
                $commentaireArticle->setArticle(null);
            }
        }

        return $this;
    }





}
