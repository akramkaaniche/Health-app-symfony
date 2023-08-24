<?php 
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChallengeRepository")
 * @ORM\Table(name="challenge", indexes={@ORM\Index(name="id_niveau", columns={"id_niveau"})})
 */
class Challenge
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     *  @Groups("challenges")
     
     */
    private $id;

    /**
     * @ORM\Column(name="titre",type="string", length=255, nullable=false)
     *  @Assert\NotBlank
     *  @Groups("challenges")
     */
    private $titre;


    /**
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     *  @Groups("challenges")
     */
    private $type;

     /**
     * @ORM\Column(name="description ", type="string")
     *  @Assert\NotBlank
     *  @Groups("challenges")
     */
    private $description;

     /**
     * @ORM\Column(name="img" ,type="string", length=255)
     *  @Groups("challenges")
     */
    private $img;

     /**
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     *  @Assert\NotBlank
     * @Assert\GreaterThanOrEqual("today") 
     *  @Groups("challenges")

     */
    private $dateDebut;

    /**
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     *  @Assert\NotBlank
     * @Assert\Expression(
     *     "this.getDateDebut() < this.getDateFin()",
     *     message="La date fin ne doit pas être antérieure à la date début"
     * )
     *  @Groups("challenges")
     */
    private $dateFin;

    /**
     * @ORM\Column(name="nb_participants", type="integer", nullable=true)
     * @Assert\PositiveOrZero
     *  @Groups("challenges")
     */
    private $nbParticipants;

    /**
     * 
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Niveau")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_niveau", referencedColumnName="id")})
     * @Assert\NotBlank
     * @Assert\PositiveOrZero
     *  @Groups("challenges")
     */
    private $idNiveau;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getimg(): ?string
    {
        return $this->img;
    }

    public function setimg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getDateDebut(): ?DateTime
    {
        return $this->dateDebut;
    }

    public function setDateDebut(DateTime $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(DateTime $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getNbParticipants(): ?int
    {
        return $this->nbParticipants;
    }
    public function setNbParticipants(int $nbParticipants): self
    {
        $this->nbParticipants=$nbParticipants;
        return $this;
    }

    public function getIdNiveau(): ?int
    {
        return $this->idNiveau;
    }
    public function setIdNiveau(int $idNiveau): self
    {
        $this->idNiveau=$idNiveau;
        return $this;
    }

    




}
