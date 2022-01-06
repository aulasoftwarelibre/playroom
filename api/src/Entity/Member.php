<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MemberRepository;
use App\Resolver\GetMeResolver;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[Uploadable]
#[ApiResource(
    graphql: [
        'getMe' => [
            'item_query' => GetMeResolver::class,
            'args' => [],
        ],
        'update' => [
            'security' => "object == user",
        ]
    ],
    denormalizationContext: ['groups' => ['write']],
    normalizationContext: ['groups' => ['read']],
)]
#[UniqueEntity('email')]
#[UniqueEntity('alias')]
class Member implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(["read"])]
    #[Assert\Sequentially(
        [
        new Assert\NotBlank(),
        new Assert\Email()
        ]
    )]
    private ?string $email;

    #[ORM\Column(type: 'string', length: 32, unique: true)]
    #[Assert\Sequentially(
        [
        new Assert\NotBlank(),
        new Assert\Length(min: 3, max: 16),
        new Assert\Regex('/[\w\d_]/u', message: 'form.label_alias_invalid')
        ]
    )]
    #[Groups(["read", "write"])]
    private ?string $alias;

    #[ORM\Column(type: 'json')]
    #[Groups(["read"])]
    #[Assert\Choice(["ROLE_USER", "ROLE_ADMIN", "ROLE_SUPER_ADMIN"], multiple: true)]
    /**
     * @var string[]
     */
    private array $roles = [];

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    #[Groups(["read", "write"])]
    #[Assert\Sequentially(
        [
        new Assert\NotBlank(),
        new Assert\Length(max: 64),
        ]
    )]
    private ?string $firstname;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    #[Groups(["read", "write"])]
    #[Assert\Sequentially(
        [
        new Assert\NotBlank(),
        new Assert\Length(max: 64),
        ]
    )]
    private ?string $lastname;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Timestampable()]
    private ?\DateTimeImmutable $updatedAt;

    #[UploadableField(
        mapping: "avatars",
        fileNameProperty: "avatar.name",
        size: "avatar.size",
        mimeType: "avatar.mimeType",
        originalName: "avatar.originalName"
    )]
    #[Assert\Image(
        minWidth: 400,
        minHeight: 400,
        maxRatio: 1,
        minRatio: 1
    )]
    private File|UploadedFile|null $avatarFile = null;

    #[ORM\Embedded(class: EmbeddedFile::class)]
    private ?EmbeddedFile $avatar;

    #[ApiProperty(iri: "https://schema.org/contentUrl")]
    #[Groups(["read"])]
    public ?string $avatarUrl = null;

    #[ORM\ManyToOne(targetEntity: Degree::class)]
    #[Assert\Valid]
    private ?Degree $degree;

    public function __construct()
    {
        $this->avatar = new EmbeddedFile();
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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

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
     * @return void
     */
    public function eraseCredentials()
    {
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAvatar(): ?EmbeddedFile
    {
        return $this->avatar;
    }

    public function setAvatar(EmbeddedFile $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAvatarFile(): File|UploadedFile|null
    {
        return $this->avatarFile;
    }

    public function setAvatarFile(File|UploadedFile|null $avatarFile): self
    {
        $this->avatarFile = $avatarFile;

        if ($avatarFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getDegree(): ?Degree
    {
        return $this->degree;
    }

    public function setDegree(?Degree $degree): self
    {
        $this->degree = $degree;

        return $this;
    }
}
