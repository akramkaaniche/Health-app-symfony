<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Therapie
 *
 * @ORM\Table(name="therapie", indexes={@ORM\Index(name="secondaire", columns={"idcoach"})})
 * @ORM\Entity
 */
class Therapie
{
    /**
     * @var int
     * @Groups("post:read")
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     *
     */
    private $id;

    /**
     * @var string
     * @Groups("post:read")
     *@Assert\NotBlank(message="le champs sujet est obligatoire  ")
     * @ORM\Column(name="sujet", type="string", length=254, nullable=false)
     */
    private $sujet;

    /**
     * @Assert\Date
     *@Groups("post:read")
     * @var date A "d/m/Y" formatted value
     * @Assert\GreaterThanOrEqual("2021-04-19")
     *@Assert\NotBlank(message="le champs date est obligatoire  ")
     * @ORM\Column(name="date", type="string", length=255, nullable=false)
     */
    private $date;

    /**
     * @var string
     * @Groups("post:read")
     *@Assert\NotBlank(message="le champs lieu est obligatoire  ")
     * @ORM\Column(name="lieu", type="string", length=254, nullable=false)
     */
    private $lieu;

    /**
     * @var int
     * @Groups("post:read")
     *@Assert\NotBlank(message="le champs nombre max est obligatoire  ")
     * @ORM\Column(name="nombremax", type="integer", nullable=false)
     */
    private $nombremax;

    /**
     * @var int
     *@Groups("post:read")
     * @ORM\Column(name="nombre_parti", type="integer", nullable=false)
     */
    private $nombreParti = '0';

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     * @Groups("post:read")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcoach", referencedColumnName="id")
     * })
     */
    private $idcoach;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    /**
     * @param string $sujet
     */
    public function setSujet(string $sujet): void
    {
        $this->sujet = $sujet;
    }

    /**
     * @return date
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param date $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    /**
     * @param string $lieu
     */
    public function setLieu(string $lieu): void
    {
        $this->lieu = $lieu;
    }

    /**
     * @return int
     */
    public function getNombremax(): ?int
    {
        return $this->nombremax;
    }

    /**
     * @param int $nombremax
     */
    public function setNombremax(int $nombremax): void
    {
        $this->nombremax = $nombremax;
    }

    /**
     * @return int
     */
    public function getNombreParti()
    {
        return $this->nombreParti;
    }

    /**
     * @param int $nombreParti
     */
    public function setNombreParti($nombreParti): void
    {
        $this->nombreParti = $nombreParti;
    }

    /**
     * @return User
     */
    public function getIdcoach(): ?User
    {
        return $this->idcoach;
    }

    /**
     * @param User $idcoach
     */
    public function setIdcoach(User $idcoach): void
    {
        $this->idcoach = $idcoach;
    }


}
