<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin
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
    private $loginName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $loginIP;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoginName(): ?string
    {
        return $this->loginName;
    }

    public function setLoginName(string $loginName): self
    {
        $this->loginName = $loginName;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getLoginIP(): ?string
    {
        return $this->loginIP;
    }

    public function setLoginIP(string $loginIP): self
    {
        $this->loginIP = $loginIP;

        return $this;
    }
}
