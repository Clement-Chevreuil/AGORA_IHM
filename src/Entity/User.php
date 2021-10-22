<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * 
     * @var string The hashed password
     * @ORM\Column(type="string")
     * /**
    
     */

    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="user", orphanRemoval=true)
     */
    private $article;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=UserArticleInformations::class, mappedBy="user", orphanRemoval=true)
     */
    private $userArticleInformations;

    /**
     * @ORM\Column(type="boolean")
     */
    private $blocked;

    /**
     * @ORM\OneToMany(targetEntity=ArchiveArticle::class, mappedBy="id_user")
     */
    private $archiveArticles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $theme_sombre;

    /**
     * @ORM\OneToMany(targetEntity=Support::class, mappedBy="user")
     */
    private $supports;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity=ArchiveSupport::class, mappedBy="user")
     */
    private $archiveSupports;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;



    public function __construct()
    {
        $this->article = new ArrayCollection();
        $this->userArticleInformations = new ArrayCollection();
        $this->archiveArticles = new ArrayCollection();
        $this->supports = new ArrayCollection();
        $this->archiveSupports = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
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
            $userArticleInformation->setUser($this);
        }

        return $this;
    }

    public function removeUserArticleInformation(UserArticleInformations $userArticleInformation): self
    {
        if ($this->userArticleInformations->removeElement($userArticleInformation)) {
            // set the owning side to null (unless already changed)
            if ($userArticleInformation->getUser() === $this) {
                $userArticleInformation->setUser(null);
            }
        }

        return $this;
    }

    public function getBlocked(): ?bool
    {
        return $this->blocked;
    }

    public function setBlocked(bool $blocked): self
    {
        $this->blocked = $blocked;

        return $this;
    }

    /**
     * @return Collection|ArchiveArticle[]
     */
    public function getArchiveArticles(): Collection
    {
        return $this->archiveArticles;
    }

    public function addArchiveArticle(ArchiveArticle $archiveArticle): self
    {
        if (!$this->archiveArticles->contains($archiveArticle)) {
            $this->archiveArticles[] = $archiveArticle;
            $archiveArticle->setIdUser($this);
        }

        return $this;
    }

    public function removeArchiveArticle(ArchiveArticle $archiveArticle): self
    {
        if ($this->archiveArticles->removeElement($archiveArticle)) {
            // set the owning side to null (unless already changed)
            if ($archiveArticle->getIdUser() === $this) {
                $archiveArticle->setIdUser(null);
            }
        }

        return $this;
    }

    public function getThemeSombre(): ?bool
    {
        return $this->theme_sombre;
    }

    public function setThemeSombre(bool $theme_sombre): self
    {
        $this->theme_sombre = $theme_sombre;

        return $this;
    }

    /**
     * @return Collection|Support[]
     */
    public function getSupports(): Collection
    {
        return $this->supports;
    }

    public function addSupport(Support $support): self
    {
        if (!$this->supports->contains($support)) {
            $this->supports[] = $support;
            $support->setUser($this);
        }

        return $this;
    }

    public function removeSupport(Support $support): self
    {
        if ($this->supports->removeElement($support)) {
            // set the owning side to null (unless already changed)
            if ($support->getUser() === $this) {
                $support->setUser(null);
            }
        }

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

    /**
     * @return Collection|ArchiveSupport[]
     */
    public function getArchiveSupports(): Collection
    {
        return $this->archiveSupports;
    }

    public function addArchiveSupport(ArchiveSupport $archiveSupport): self
    {
        if (!$this->archiveSupports->contains($archiveSupport)) {
            $this->archiveSupports[] = $archiveSupport;
            $archiveSupport->setUser($this);
        }

        return $this;
    }

    public function removeArchiveSupport(ArchiveSupport $archiveSupport): self
    {
        if ($this->archiveSupports->removeElement($archiveSupport)) {
            // set the owning side to null (unless already changed)
            if ($archiveSupport->getUser() === $this) {
                $archiveSupport->setUser(null);
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


}
