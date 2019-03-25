<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjetRepository")
 * @ApiResource()
 */
class Projet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="projets", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chef;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tableau", mappedBy="projet", cascade={"persist"}, fetch="EAGER")
     */
    private $tableaux;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
        $this->tableaux = new ArrayCollection();
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

    public function getChef(): ?User
    {
        return $this->chef;
    }

    public function setChef(?User $chef): self
    {
        $this->chef = $chef;

        return $this;
    }

    /**
     * @return Collection|Tableau[]
     */
    public function getTableaux(): Collection
    {
        return $this->tableaux;
    }

    public function addTableaux(Tableau $tableaux): self
    {
        if (!$this->tableaux->contains($tableaux)) {
            $this->tableaux[] = $tableaux;
            $tableaux->setProjet($this);
        }

        return $this;
    }

    public function removeTableaux(Tableau $tableaux): self
    {
        if ($this->tableaux->contains($tableaux)) {
            $this->tableaux->removeElement($tableaux);
            // set the owning side to null (unless already changed)
            if ($tableaux->getProjet() === $this) {
                $tableaux->setProjet(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
