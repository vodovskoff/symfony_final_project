<?php

namespace App\Entity;

use App\Repository\BattleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BattleRepository::class)
 */
class Battle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dateOfBattle;

    /**
     * @ORM\ManyToOne(targetEntity=Map::class, inversedBy="battles")
     */
    private $battleMap;

    /**
     * @ORM\ManyToMany(targetEntity=Player::class, mappedBy="PlayerBattles")
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

    public function getDateOfBattle(): ?string
    {
        return $this->dateOfBattle;
    }

    public function setDateOfBattle(?string $dateOfBattle): self
    {
        $this->dateOfBattle = $dateOfBattle;

        return $this;
    }

    public function getBattleMap(): ?Map
    {
        return $this->battleMap;
    }

    public function setBattleMap(?Map $battleMap): self
    {
        $this->battleMap = $battleMap;

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
            $Player->addPlayerBattle($this);
        }

        return $this;
    }

    public function removePlayer(Player $Player): self
    {
        if ($this->Players->removeElement($Player)) {
            $Player->removePlayerBattle($this);
        }

        return $this;
    }
    public function __toString()
    {
        return strval( $this->getBattleMap()." ".$this->dateOfBattle);
    }
}
