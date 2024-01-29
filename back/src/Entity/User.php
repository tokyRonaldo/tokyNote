<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @ApiResource(
 *     collectionOperations={
 *         "me"={
 *             "method"="GET",
 *             "path"="/me",
 *             "controller"="App\Controller\MeController::class",
 *             "read"=false,
 *             "pagination_enabled"=false,
 *             "security"="is_granted('ROLE_USER')"
 *         },
 *         "get",
 *         "post"
 *     }
 * )
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:noteBloc"})
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
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=NoteBloc::class, mappedBy="userId")
     */
    private $noteBlocs;

    /**
     * @ORM\OneToMany(targetEntity=TokyTest::class, mappedBy="user")
     */
    private $tokyTests;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read:noteBloc"})
     */
    private $username;

    public function __construct()
    {
        $this->noteBlocs = new ArrayCollection();
        $this->tokyTests = new ArrayCollection();
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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, NoteBloc>
     */
    public function getNoteBlocs(): Collection
    {
        return $this->noteBlocs;
    }

    public function addNoteBloc(NoteBloc $noteBloc): self
    {
        if (!$this->noteBlocs->contains($noteBloc)) {
            $this->noteBlocs[] = $noteBloc;
            $noteBloc->setUserId($this);
        }

        return $this;
    }

    public function removeNoteBloc(NoteBloc $noteBloc): self
    {
        if ($this->noteBlocs->removeElement($noteBloc)) {
            // set the owning side to null (unless already changed)
            if ($noteBloc->getUserId() === $this) {
                $noteBloc->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TokyTest>
     */
    public function getTokyTests(): Collection
    {
        return $this->tokyTests;
    }

    public function addTokyTest(TokyTest $tokyTest): self
    {
        if (!$this->tokyTests->contains($tokyTest)) {
            $this->tokyTests[] = $tokyTest;
            $tokyTest->setUser($this);
        }

        return $this;
    }

    public function removeTokyTest(TokyTest $tokyTest): self
    {
        if ($this->tokyTests->removeElement($tokyTest)) {
            // set the owning side to null (unless already changed)
            if ($tokyTest->getUser() === $this) {
                $tokyTest->setUser(null);
            }
        }

        return $this;
    }

    public function getUsername(): string
    {
        // Assurez-vous que cette méthode retourne le champ utilisé pour le nom d'utilisateur
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }
}
