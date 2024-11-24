<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DeveloperRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DeveloperRepository::class)]
#[ApiResource]
class Developer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank]
    private string $fullName;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    #[Assert\LessThan(value: '-18 years',
                      message: 'Принимаемому сотруднику должно быть больше 18 лет.')]
    private \DateTimeInterface $birthDate;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $position;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Email(
        message: 'Это значение {{ value }} не является валидным электронным адресом.',
    )]
    private ?string $email = null;

    #[ORM\Column(length: 11, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/[\d]{11}/',
                   message: 'Номер телефона может содержать только цифры.')]
    #[Assert\Length(exactly: 11,
                    exactMessage: "Это значение должно иметь ровно {{ limit }} цифр.")]    
    private string $phoneNumber;

    /**
     * @var Collection<int, Project>
     */
    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'developers')]
    private Collection $projects;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private \DateTimeInterface $hireDate;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fireDate = null;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        $this->projects->removeElement($project);

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getHireDate(): ?\DateTimeInterface
    {
        return $this->hireDate;
    }

    public function setHireDate(\DateTimeInterface $hireDate): static
    {
        $this->hireDate = $hireDate;

        return $this;
    }

    public function getFireDate(): ?\DateTimeInterface
    {
        return $this->fireDate;
    }

    public function setFireDate(?\DateTimeInterface $fireDate): static
    {
        $this->fireDate = $fireDate;

        return $this;
    }
}
