<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Suivi
 * @ORM\Table(name="suivi", indexes={@ORM\Index(name="fk_SuivObj", columns={"idObjectif"}), @ORM\Index(name="fk_SuivCli", columns={"idClient"})})
 * @ORM\Entity(repositoryClass="App\Repository\SuiviRepository")
 */
class Suivi
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
     * @ORM\Column(name="valeur", type="integer", nullable=false)
     */
    private $valeur;

    /**
     * @Assert\Date
     * @var date A "d/m/Y" formatted value
     * @ORM\Column(name="date", type="string", length=50, nullable=false)
     */
    private $date;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idClient", referencedColumnName="id")
     * })
     */
    private $idclient;

    /**
     * @var \Objectif
     *
     * @ORM\ManyToOne(targetEntity=Objectif::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idObjectif", referencedColumnName="id")
     * })
     */
    private $idobjectif;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $color;

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
     * @return int
     */
    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    /**
     * @param int $valeur
     */
    public function setValeur(int $valeur): void
    {
        $this->valeur = $valeur;
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
     * @return User
     */
    public function getIdclient(): ?User
    {
        return $this->idclient;
    }

    /**
     * @param User $idclient
     */
    public function setIdclient(User $idclient): void
    {
        $this->idclient = $idclient;
    }

    /**
     * @return Objectif
     */
    public function getIdobjectif(): ?Objectif
    {
        return $this->idobjectif;
    }

    /**
     * @param Objectif $idobjectif
     */
    public function setIdobjectif(Objectif $idobjectif): void
    {
        $this->idobjectif = $idobjectif;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }


}
