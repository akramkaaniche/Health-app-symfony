<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participationtherapie
 *
 * @ORM\Table(name="participationtherapie", indexes={@ORM\Index(name="fk_client", columns={"id_client"})})
 * @ORM\Entity
 */
class Participationtherapie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_therapie", type="integer", nullable=false)
     */
    private $idTherapie;

    /**
     * @var int|null
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
     */
    private $rating;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aime", type="integer", nullable=true)
     */
    private $aime = '0';

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     * })
     */
    private $idClient;

    /**
     * @return int
     */
    public function getId(): int
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
     * @return int
     */
    public function getIdTherapie(): ?int
    {
        return $this->idTherapie;
    }

    /**
     * @param int $idTherapie
     */
    public function setIdTherapie(int $idTherapie): void
    {
        $this->idTherapie = $idTherapie;
    }

    /**
     * @return int|null
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * @param int|null $rating
     */
    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return int|null
     */
    public function getAime()
    {
        return $this->aime;
    }

    /**
     * @param int|null $aime
     */
    public function setAime($aime): void
    {
        $this->aime = $aime;
    }

    /**
     * @return User
     */
    public function getIdClient(): ?User
    {
        return $this->idClient;
    }

    /**
     * @param User $idClient
     */
    public function setIdClient(User $idClient): void
    {
        $this->idClient = $idClient;
    }


}
