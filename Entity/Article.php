<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("article")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     * @Groups("article")
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=255, nullable=false)
     * @Groups("article")
     */
    private $theme;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_auteur", type="string", length=255, nullable=false)
     * @Groups("article")
     */
    private $nomAuteur;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255, nullable=false)
     * @Groups("article")
     */
    private $date;

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
     * @return string
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getTheme(): ?string
    {
        return $this->theme;
    }

    /**
     * @param string $theme
     */
    public function setTheme(string $theme): void
    {
        $this->theme = $theme;
    }

    /**
     * @return string
     */
    public function getNomAuteur(): ?string
    {
        return $this->nomAuteur;
    }

    /**
     * @param string $nomAuteur
     */
    public function setNomAuteur(string $nomAuteur): void
    {
        $this->nomAuteur = $nomAuteur;
    }

    /**
     * @return string
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param string $article
     */
    public function setArticle($article): void
    {
        $this->article = $article;
    }

    /**
     * @return string
     */
    public function getIdUser():?string
    {
        return $this->idUser;
    }

    /**
     * @param string $idUser
     */
    public function setIdUser(string $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getApprouver()
    {
        return $this->approuver;
    }

    /**
     * @param int $approuver
     */
    public function setApprouver($approuver): void
    {
        $this->approuver = $approuver;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="article", type="string", length=255, nullable=false)
     * @Groups("article")
     */
    private $article;

    /**
     * @var string
     *
     * @ORM\Column(name="id_user", type="string", length=255, nullable=false)
     * @Groups("article")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="approuver", type="integer", nullable=false)
     * @Groups("article")
     */
    private $approuver = '0';


}
