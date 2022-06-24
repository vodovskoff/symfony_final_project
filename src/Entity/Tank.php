<?php

namespace App\Entity;

use App\Repository\TankRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TankRepository::class)
 */
class Tank
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
    private $tankName;

    /**
     * @ORM\ManyToOne(targetEntity=Nation::class, inversedBy="tanks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tankNation;

    /**
     * @ORM\ManyToMany(targetEntity=Player::class, mappedBy="PlayerTanks")
     */
    private $Players;

    public function __construct()
    {
        $this->Players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTankName(): ?string
    {
        return $this->tankName;
    }

    public function setTankName(string $tankName): self
    {
        $this->tankName = $tankName;

        return $this;
    }

    public function getTankNation(): ?Nation
    {
        return $this->tankNation;
    }

    public function setTankNation(?Nation $tankNation): self
    {
        $this->tankNation = $tankNation;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->Players;
    }

    public function addPlayer(Player $Player): self
    {
        if (!$this->Players->contains($Player)) {
            $this->Players[] = $Player;
            $Player->addPlayerTank($this);
        }

        return $this;
    }

    public function removePlayer(Player $Player): self
    {
        if ($this->Players->removeElement($Player)) {
            $Player->removePlayerTank($this);
        }

        return $this;
    }
    public function __toString(){
        return strval( $this->tankName." (".$this->tankNation.")");
    }
}
