<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activite
 *
 * @ORM\Table(name="activite", indexes={@ORM\Index(name="act1", columns={"idcoach"})})
 * @ORM\Entity
 */
class Activite
{
    /**
     * @var int
     *@Groups("post:read")
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     *
     */
    private $id;

    /**
     * @var string
     *@Groups("post:read")
     * @ORM\Column(name="duree", type="string", length=255, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 4,
     *     minMessage = "Duree doit etre minimun 10 min",
     *      allowEmptyString = false
     *      )
     */
    private $duree;

    /**
     *
     * @Assert\Date
     *@Groups("post:read")
     * @var date A "d/m/Y" formatted value
     * @Assert\GreaterThanOrEqual("2021-04-28")
     *@Assert\NotBlank(message="le champs date est obligatoire  ")
     * @ORM\Column(name="date", type="string", length=255, nullable=false)
     */
    private $date;

    /**
     * @var int
     * @Groups("post:read")
     *@Assert\NotBlank(message="le champs nombre max est obligatoire  ")
     * @ORM\Column(name="nombremax", type="integer", nullable=false)
     */
    private $nombremax;

    /**
     * @var string
     * @Groups("post:read")
     *@Assert\NotBlank(message="le champs type est obligatoire * ")
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var string
     * @Groups("post:read")
     *@Assert\NotBlank(message="le champs description est obligatoire  ")
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     * @Groups("post:read")
     *     *@Assert\NotBlank(message="le champs lieu est obligatoire  ")
     * @ORM\Column(name="lieu", type="string", length=255, nullable=false)
     */
    private $lieu;

    /**
     * @var int
     * @Groups("post:read")
     * @ORM\Column(name="nombre_parti", type="integer", nullable=false)
     */
    private $nombreParti = '0';

    /**
     * @var \User
     *@Groups("post:read")
     * @ORM\ManyToOne(targetEntity=User::class)
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
