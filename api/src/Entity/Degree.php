<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DegreeRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DegreeRepository::class)]
#[ApiResource(
    graphql: [
        "item_query",
        "collection_query",

    ],
    normalizationContext: ['groups' => ['read']],
)]
#[UniqueEntity("name")]
#[UniqueEntity("slug")]
class Degree
{
    public const TYPE_DEGREE = "DEGREE";
    public const TYPE_MASTER = "MASTER";
    public const TYPE_DOCTOR = "DOCTOR";
    public const TYPE_OTHERS = "OTHERS";
    public const TYPES = [
        self::TYPE_DEGREE => "Grado",
        self::TYPE_MASTER => "Máster",
        self::TYPE_DOCTOR => "Doctorado",
        self::TYPE_OTHERS => "Títulos propios",
    ];

    public const FAMILY_ARTS = "ARTS";
    public const FAMILY_SCIENCE = "SCIENCE";
    public const FAMILY_HEALTH = "HEALTH";
    public const FAMILY_SOCIAL = "SOCIAL";
    public const FAMILY_ENGINEERING = "ENGINEERING";
    public const FAMILIES = [
        self::FAMILY_ARTS => "Artes y Humanidades",
        self::FAMILY_SCIENCE => "Ciencias",
        self::FAMILY_HEALTH => "Ciencias de la Salud",
        self::FAMILY_SOCIAL => "Ciencias Sociales y Jurídicas",
        self::FAMILY_ENGINEERING => "Ingeniería y Arquitectura",
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\Sequentially(
        [
        new Assert\NotBlank(),
        new Assert\Length(max: 255)
        ]
    )]
    #[Groups(["read"])]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Slug(fields: ['name'])]
    #[Groups(["read"])]
    private ?string $slug;

    #[ORM\Column(type: 'string', length: 16)]
    #[Assert\Sequentially(
        [
        new Assert\NotBlank(),
        new Assert\Choice([self::TYPE_DEGREE, self::TYPE_MASTER, self::TYPE_DOCTOR, self::TYPE_OTHERS])
        ]
    )]
    #[Groups(["read"])]
    private ?string $type;

    #[ORM\Column(type: 'string', length: 16, nullable: true)]
    #[Assert\Sequentially(
        [
        new Assert\Choice([self::FAMILY_ARTS, self::FAMILY_SCIENCE, self::FAMILY_HEALTH, self::FAMILY_SOCIAL, self::FAMILY_ENGINEERING])
        ]
    )]
    #[Groups(["read"])]
    private ?string $family;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Timestampable]
    private ?\DateTimeImmutable $updatedAt;

    public function __toString(): string
    {
        return (string) $this->getName();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(?string $family): self
    {
        $this->family = $family;

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
}
