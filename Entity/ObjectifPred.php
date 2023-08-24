<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ObjectifPred
 * @ORM\Table(name="objectif_pred", indexes={@ORM\Index(name="fk_ObjAd", columns={"idAdmin"})})
 * @ORM\Entity(repositoryClass="App\Repository\ObjectifPredRepository")
 */
class ObjectifPred
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     */
    private $description;

    /**
     * @var int
     * @Assert\Positive
     * @ORM\Column(name="duree", type="integer", nullable=false)
     */
    private $duree;

    /**
     * @var string
     *
     * @ORM\Column(name="icone", type="string", length=50, nullable=false)
     */
    private $icone;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAdmin", referencedColumnName="id")
     * })
     */
    private $idadmin;

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
     * @return string)
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
     * @return int
     */
    public function getDuree(): ?int
    {
        return $this->duree;
    }

    /**
     * @param int $duree
     */
    public function setDuree(int $duree): void
    {
        $this->duree = $duree;
    }

    /**
     * @return string
     */
    public function getIcone(): ?string
    {
        return $this->icone;
    }

    /**
     * @param string $icone
     */
    public function setIcone(string $icone): void
    {
        $this->icone = $icone;
    }

    /**
     * @return User
     */
    public function getIdadmin(): ?User
    {
        return $this->idadmin;
    }

    /**
     * @param User $idadmin
     */
    public function setIdadmin(User $idadmin): void
    {
        $this->idadmin = $idadmin;
    }
    public function __toString(): string
    {
        return $this->description;
    }


}
