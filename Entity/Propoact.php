<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Propoact
 *
 * @ORM\Table(name="propoact", indexes={@ORM\Index(name="idcoach", columns={"idcoach"})})
 * @ORM\Entity
 */
class Propoact
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     *
     */
    private $id;

    /**
     * @var string
     *@Assert\NotBlank(message="le champs duree est obligatoire  ")
     * @ORM\Column(name="duree", type="string", length=255, nullable=false)
     */
    private $duree;

    /**
     * @Assert\Date
     *
     * @var date A "d/m/Y" formatted value
     * @Assert\GreaterThanOrEqual("2021-04-19")
     *@Assert\NotBlank(message="le champs date est obligatoire  ")
     * @ORM\Column(name="date", type="string", length=255, nullable=false)
     */
    private $date;

    /**
     * @var int
     *@Assert\NotBlank(message="le champs nombre max est obligatoire  ")
     * @ORM\Column(name="nombremax", type="integer", nullable=false)
     */
    private $nombremax;

    /**
     * @var string
     *@Assert\NotBlank(message="le champs type est obligatoire  ")
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var string
     *@Assert\NotBlank(message="le champs description est obligatoire  ")
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *@Assert\NotBlank(message="le champs lieu est obligatoire  ")
     * @ORM\Column(name="lieu", type="string", length=255, nullable=false)
     */
    private $lieu;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_parti", type="integer", nullable=false)
     */
    private $nombreParti = '0';

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcoach", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="le champs id coach est obligatoire  ")
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
    public function getDuree(): ?string
    {
        return $this->duree;
    }

    /**
     * @param string $duree
     */
    public function setDuree(string $duree): void
    {
        $this->duree = $duree;
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
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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
    public function getNombreParti(): ?int
    {
        return $this->nombreParti;
    }

    /**
     * @param int $nombreParti
     */
    public function setNombreParti(int $nombreParti): void
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
