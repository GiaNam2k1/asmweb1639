<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Name;

    #[ORM\Column(type: 'integer')]
    private $CourseID;

    #[ORM\Column(type: 'string', length: 255)]
    private $Description;

    #[ORM\ManyToOne(targetEntity: CourseCategory::class, inversedBy: 'courses')]
    private $courseCategory;

    #[ORM\ManyToMany(targetEntity: Classroom::class, inversedBy: 'courses')]
    private $classes;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getCourseID(): ?int
    {
        return $this->CourseID;
    }

    public function setCourseID(int $CourseID): self
    {
        $this->CourseID = $CourseID;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getCourseCategory(): ?CourseCategory
    {
        return $this->courseCategory;
    }

    public function setCourseCategory(?CourseCategory $courseCategory): self
    {
        $this->courseCategory = $courseCategory;

        return $this;
    }

    /**
     * @return Collection|Classroom[]
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classroom $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes[] = $class;
        }

        return $this;
    }

    public function removeClass(Classroom $class): self
    {
        $this->classes->removeElement($class);

        return $this;
    }
}
