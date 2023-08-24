<?php

namespace App\Entity;
use App\Repository\ClassementRepository;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassementRepository")
 *  * @ORM\Table(name="`ligne_classement`")
 */
class Classement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="id_client" ,type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(max=8)
     * @Groups("classements")
     */
    private $idClient;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Groups("classements")
     */
    private $idNiveau;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\PositiveOrZero
     * @Groups("classements")
     */
    private $position;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\PositiveOrZero
     *  @ORM\OrderBy({"order" = "DESC", "nb_points" = "DESC"})
     * @Groups("classements")
     */
    private $nbPoints;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdClient(): ?string
    {
        return $this->idClient;
    }

    public function setIdClient(string $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getIdNiveau(): ?string
    {
        return $this->idNiveau;
    }

    public function setIdNiveau(string $idNiveau): self
    {
        $this->idNiveau = $idNiveau;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getNbPoints(): ?int
    {
        return $this->nbPoints;
    }

    public function setNbPoints(string $nbPoints): self
    {
        $this->nbPoints = $nbPoints;

        return $this;
    }
}







