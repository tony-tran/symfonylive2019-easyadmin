<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Publication", mappedBy="category")
     */
    private $publication;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->publication = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Publication[]
     */
    public function getPublication(): Collection
    {
        return $this->publication;
    }

    public function addPublication(Publication $publication): self
    {
        if (!$this->publication->contains($publication)) {
            $this->publication[] = $publication;
            $publication->setCategory($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): self
    {
        if ($this->publication->contains($publication)) {
            $this->publication->removeElement($publication);
            // set the owning side to null (unless already changed)
            if ($publication->getCategory() === $this) {
                $publication->setCategory(null);
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

    public function __toString(): string
    {
        return $this->name;
    }
}
