<?php

namespace App\Entity;

use App\Repository\CourseCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseCategoryRepository::class)]
class CourseCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Name;

    #[ORM\Column(type: 'string', length: 255)]
    private $Description;

    #[ORM\OneToMany(mappedBy: 'courseCategory', targetEntity: Course::class)]
    private $Courses;

    public function __construct()
    {
        $this->Courses = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getCourses(): Collection
    {
        return $this->Courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->Courses->contains($course)) {
            $this->Courses[] = $course;
            $course->setCourseCategory($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->Courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getCourseCategory() === $this) {
                $course->setCourseCategory(null);
            }
        }

        return $this;
    }
}
