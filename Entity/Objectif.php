<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Objectif
 * @ORM\Table(name="objectif", indexes={@ORM\Index(name="fk_objcli", columns={"idClient"})})
 * @ORM\Entity(repositoryClass="App\Repository\ObjectifRepository")
 * @Vich\Uploadable
 */
class Objectif
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Assert\Length(min=3)
     * @Groups("post:read")
     */
    private $description;

    /**
     * @var int
     * @Assert\Positive
     * @ORM\Column(name="reponse", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $reponse;

    /**
     * @Assert\Date
     * @var date A "dd/MM/yyyy" formatted value
     * @ORM\Column(name="dateDebut", type="string", length=50, nullable=false)
     * @Groups("post:read")
     */
    private $datedebut;

    /**
     * @var int
     * @Assert\Positive
     * @ORM\Column(name="duree", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $duree;

    /**
     * @var int
     *
     * @ORM\Column(name="mailchecked", type="integer", nullable=true)
     * @Groups("post:read")
     */
    private $mailchecked;

    /**
     * @var string
     *
     * @ORM\Column(name="icone", type="string", length=50, nullable=true)
     * @Groups("post:read")
     */
    private $icone;

    /**
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     * @var string
     * @Groups("post:read")
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="objectifs", fileNameProperty="image")
     * @var File
     * @Groups("post:read")
     */
    private $imageFile;


    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idClient", referencedColumnName="id")
     * })
     * @Groups("post:read")
     */
    private $idclient;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Groups("post:read")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("post:read")
     */
    private $updated_at;


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
    public function getReponse(): ?int
    {
        return $this->reponse;
    }

    /**
     * @param int $reponse
     */
    public function setReponse(int $reponse): void
    {
        $this->reponse = $reponse;
    }

    /**
     * @return date
     */
    public function getDatedebut(): ?string
    {
        return $this->datedebut;
    }

    /**
     * @param date $datedebut
     */
    public function setDatedebut(string $datedebut): void
    {
        $this->datedebut = $datedebut;
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
     * @return int
     */
    public function getMailchecked(): ?int
    {
        return $this->mailchecked;
    }

    /**
     * @param int $mailchecked
     */
    public function setMailchecked(int $mailchecked): void
    {
        $this->mailchecked = $mailchecked;
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


    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string $icone
     */
    public function setImage(string $image): void
    {
        $this->icone = $image;
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
    public function setIdclient(User $idclient)
    {
        $this->idclient = $idclient;
    }
    public function __toString(): string
    {
        return $this->description;
    }

    public function getDateFin(): ?string
    {
        return $this->dateFin;
    }

    public function setDateFin(?string $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }


}
