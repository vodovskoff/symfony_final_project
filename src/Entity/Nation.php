<?php

namespace App\Entity;

use App\Repository\NationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NationRepository::class)
 */
class Nation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationName;

    /**
     * @ORM\OneToMany(targetEntity=Tank::class, mappedBy="tankNation", orphanRemoval=true)
     */
    private $tanks;

    public function __construct()
    {
        $this->tanks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNationName(): ?string
    {
        return $this->nationName;
    }

    public function setNationName(string $nationName): self
    {
        $this->nationName = $nationName;

        return $this;
    }

    /**
     * @return Collection<int, Tank>
     */
    public function getTanks(): Collection
    {
        return $this->tanks;
    }

    public function addTank(Tank $tank): self
    {
        if (!$this->tanks->contains($tank)) {
            $this->tanks[] = $tank;
            $tank->setTankNation($this);
        }

        return $this;
    }

    public function removeTank(Tank $tank): self
    {
        if ($this->tanks->removeElement($tank)) {
            // set the owning side to null (unless already changed)
            if ($tank->getTankNation() === $this) {
                $tank->setTankNation(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return strval($this->getNationName());
    }
}
