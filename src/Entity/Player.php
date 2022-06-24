<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
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
    private $PlayerName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dateOfRegistration;

    /**
     * @ORM\ManyToMany(targetEntity=Tank::class, inversedBy="Players")
     */
    private $PlayerTanks;

    /**
     * @ORM\ManyToMany(targetEntity=Battle::class, inversedBy="Players")
     */
    private $PlayerBattles;
    
    private $countBattles;

    public function __construct()
    {
        $this->PlayerTanks = new ArrayCollection();
        $this->PlayerBattles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayerName(): ?string
    {
        return $this->PlayerName;
    }

    public function setPlayerName(string $PlayerName): self
    {
        $this->PlayerName = $PlayerName;

        return $this;
    }

    public function getDateOfRegistration(): ?string
    {
        return $this->dateOfRegistration;
    }

    public function setDateOfRegistration(?string $dateOfRegistration): self
    {
        $this->dateOfRegistration = $dateOfRegistration;

        return $this;
    }

    /**
     * @return Collection<int, Tank>
     */
    public function getPlayerTanks(): Collection
    {
        return $this->PlayerTanks;
    }

    public function addPlayerTank(Tank $PlayerTank): self
    {
        if (!$this->PlayerTanks->contains($PlayerTank)) {
            $this->PlayerTanks[] = $PlayerTank;
        }

        return $this;
    }

    public function removePlayerTank(Tank $PlayerTank): self
    {
        $this->PlayerTanks->removeElement($PlayerTank);

        return $this;
    }

    /**
     * @return Collection<int, Battle>
     */
    public function getPlayerBattles(): Collection
    {
        return $this->PlayerBattles;
    }

    public function addPlayerBattle(Battle $PlayerBattle): self
    {
        if (!$this->PlayerBattles->contains($PlayerBattle)) {
            $this->PlayerBattles[] = $PlayerBattle;
        }

        return $this;
    }

    public function removePlayerBattle(Battle $PlayerBattle): self
    {
        $this->PlayerBattles->removeElement($PlayerBattle);

        return $this;
    }
    public function __toString(){
        return strval( $this->PlayerName);
    }
}
