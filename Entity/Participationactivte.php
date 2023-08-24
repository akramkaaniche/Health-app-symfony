<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participationactivte
 *
 * @ORM\Table(name="participationactivte", indexes={@ORM\Index(name="fk_acti", columns={"id_activite"}), @ORM\Index(name="fk_cl", columns={"id_client"})})
 * @ORM\Entity
 */
class Participationactivte
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
     * @var int|null
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
     */
    private $rating= '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="aime", type="integer", nullable=true)
     */
    private $aime = '0';

    /**
     * @var \Activite
     *
     * @ORM\ManyToOne(targetEntity=Activite::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_activite", referencedColumnName="id")
     * })
     */
    private $idActivite;

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
     * @return int|null
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int|null $rating
     */
    public function setRating(int $rating): void
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
     * @return Activite
     */
    public function getIdActivite(): ?Activite
    {
        return $this->idActivite;
    }

    /**
     * @param Activite $idActivite
     */
    public function setIdActivite(Activite $idActivite): void
    {
        $this->idActivite = $idActivite;
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
