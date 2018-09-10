<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Poi", mappedBy="project_id", orphanRemoval=true)
     */
    private $pois;

    public function __construct()
    {
        $this->pois = new ArrayCollection();
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

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection|Poi[]
     */
    public function getPois(): Collection
    {
        return $this->pois;
    }

    public function addPois(Poi $pois): self
    {
        if (!$this->pois->contains($pois)) {
            $this->pois[] = $pois;
            $pois->setProjectId($this);
        }

        return $this;
    }

    public function removePois(Poi $pois): self
    {
        if ($this->pois->contains($pois)) {
            $this->pois->removeElement($pois);
            // set the owning side to null (unless already changed)
            if ($pois->getProjectId() === $this) {
                $pois->setProjectId(null);
            }
        }

        return $this;
    }
}
