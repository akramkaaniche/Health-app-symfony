<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ReponseRepository;

/**
 * Repentraide
 *
 * @ORM\Table(name="repentraide", indexes={@ORM\Index(name="fk_id_q", columns={"id_question"}), @ORM\Index(name="fk_id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Repentraide
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *@Groups("post:read")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="string", length=255, nullable=false)
     *@Groups("post:read")
     */
    private $reponse;

    /**
     * @var \Entraide
     *
     * @ORM\ManyToOne(targetEntity=Entraide::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_question", referencedColumnName="id")
     * })
     */
    private $idQuestion;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     *
     */
    private $idUser;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     * @Groups("post:read")
     */
    private $createdAt ;






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
    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    /**
     * @param string $reponse
     */
    public function setReponse(string $reponse): void
    {
        $this->reponse = $reponse;
    }

    /**
     * @return Entraide
     */
    public function getIdQuestion(): ?Entraide
    {
        return $this->idQuestion;
    }

    /**
     * @param Entraide $idQuestion
     */
    public function setIdQuestion(Entraide $idQuestion): void
    {
        $this->idQuestion = $idQuestion;
    }

    /**
     * @return User
     */
    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    /**
     * @param User $idUser
     */
    public function setIdUser(User $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {

        return $this->createdAt->format('d/m/Y');


    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }



}
