<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
#[Uploadable]
#[ApiResource(
    graphql: [
        "item_query",
        'collection_query',
    ],
    normalizationContext: ['groups' => ['read']],
)]
#[ApiFilter(OrderFilter::class, properties: ["name"], arguments: ["orderParameterName" => "order"])]
#[UniqueEntity(fields: ["name"])]
#[UniqueEntity(fields: ["slug"])]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[NotBlank]
    #[Length(max: 180)]
    #[Groups(["read"])]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[NotBlank]
    #[Length(max: 180)]
    #[Groups(["read"])]
    private ?string $slug;

    #[ORM\Column(type: 'string', length: 200)]
    #[NotBlank]
    #[Length(max: 200)]
    #[Groups(["read"])]
    private ?string $description;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Timestampable()]
    private ?\DateTimeImmutable $updatedAt;

    #[UploadableField(
        mapping: "profiles",
        fileNameProperty: "image.name",
        size: "image.size",
        mimeType: "image.mimeType",
        originalName: "image.originalName"
    )]
    #[Image(
        minWidth: 1200,
        minHeight: 600,
        maxRatio: 2,
        minRatio: 2
    )]
    private File|UploadedFile|null $imageFile = null;

    /**
     * @var ?EmbeddedFile
     */
    #[ORM\Embedded(class: EmbeddedFile::class)]
    private ?EmbeddedFile $image;

    #[ApiProperty(iri: "https://schema.org/contentUrl")]
    #[Groups(["read"])]
    public ?string $imageUrl = null;

    #[UploadableField(
        mapping: "avatars",
        fileNameProperty: "avatar.name",
        size: "avatar.size",
        mimeType: "avatar.mimeType",
        originalName: "avatar.originalName"
    )]
    #[Image(
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

    public function __construct()
    {
        $this->image = new EmbeddedFile();
        $this->avatar = new EmbeddedFile();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getImage(): ?EmbeddedFile
    {
        return $this->image;
    }

    public function setImage(EmbeddedFile $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile(): File|UploadedFile|null
    {
        return $this->imageFile;
    }

    public function setImageFile(File|UploadedFile|null $imageFile): Room
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

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

    public function setAvatarFile(File|UploadedFile|null $avatarFile): Room
    {
        $this->avatarFile = $avatarFile;

        if ($avatarFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }
}
