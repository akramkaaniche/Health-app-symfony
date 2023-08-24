<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Validators as MyValidate;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface;




/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"email"},
 *     message="L'adresse Email deja existe."
 * )
 * @UniqueEntity(
 *     fields={"id"},
 *     message="Cin existe deja ."
 * )
 *   @ORM\Entity (repositoryClass="App\Repository\UserRepository")

 */
class User implements UserInterface, \Serializable, TwoFactorInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=255, nullable=false)
     * @ORM\Id
     * @MyValidate\VerifCin
     * @Groups ("post:read")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @MyValidate\VerifNull(groups={"modify"})
     * @Groups ("post:read")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     * @MyValidate\VerifNull(groups={"modify"})
     * @Groups ("post:read")
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @MyValidate\VerifEmail
     *  @Groups ("post:read")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @MyValidate\VerifPassword(groups={"resetPassword"})
     *  @Groups ("post:read")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=false)
     * @MyValidate\VerifTel(groups={"modify"})
     *  @Groups ("post:read")
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="specialite", type="string", length=255, nullable=false)
     *  @MyValidate\VerifNull(groups={"modify"})
     * @Groups ("post:read")
     */
    private $specialite;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=false)
     *  @Groups ("post:read")
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, nullable=false)
     * @Groups ("post:read")
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="json")
     * @Groups ("post:read")
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="rme", type="string", length=255, nullable=false, options={"default"="N"})
     * @Groups ("post:read")
     */
    private $rme = 'N';

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255, nullable=false)
     * @Groups ("post:read")
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="sms", type="string", length=255, nullable=false, options={"default"="N"})
     * @Groups ("post:read")
     */
    private $sms = 'N';

    /**
     * @ORM\Column(name="googleAuthenticatorSecret", type="string", nullable=true)
     * @Groups ("post:read")
     */
    private $googleAuthenticatorSecret;

    /**
     * @var string
     *
     * @ORM\Column(name="googleAccount", type="string", length=255, nullable=false, options={"default"="N"})
     * @Groups ("post:read")
     */
    private $googleAccount = 'N';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups ("post:read")
     */
    private $activation_token;

    /**
     * @ORM\Column(type="string", length=255,nullable=false, options={"default"="N"})
     * @Groups ("post:read")
     */
    private $notifyAddCoach;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }



    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }



    public function getRme(): ?string
    {
        return $this->rme;
    }

    public function setRme(string $rme): self
    {
        $this->rme = $rme;

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture( $picture)
    {
        $this->picture = $picture;

        return $this;
    }

    public function getSms(): ?string
    {
        return $this->sms;
    }

    public function setSms(string $sms): self
    {
        $this->sms = $sms;

        return $this;
    }

    public function getGoogleAccount(): ?string
    {
        return $this->googleAccount;
    }

    public function setGoogleAccount(string $googleAccount): self
    {
        $this->googleAccount = $googleAccount;

        return $this;
    }


    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->id;

    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function serialize()
    {
        return serialize(
          [
            $this->id,
              $this->nom,
              $this->prenom,
              $this->email,
              $this->password,
              $this->tel,
              $this->adresse,
              $this->specialite,
              $this->sms,
              $this->rme,
              $this->picture,
              $this->role
          ]

        );
        // TODO: Implement serialize() method.
    }

    public function unserialize($string)
    {
        list(
            $this->id,
            $this->nom,
            $this->prenom,
            $this->email,
            $this->password,
            $this->tel,
            $this->adresse,
            $this->specialite,
            $this->sms,
            $this->rme,
            $this->picture,
            $this->role

            )=unserialize($string,['allowed_classes'=>false]);
    }

    public function isGoogleAuthenticatorEnabled(): bool
    {
        return $this->googleAuthenticatorSecret ? true : false;
    }

    public function getGoogleAuthenticatorUsername(): string
    {
        return $this->id;
    }

    public function getGoogleAuthenticatorSecret(): ?string
    {
        return $this->googleAuthenticatorSecret;
    }

    public function setGoogleAuthenticatorSecret(?string $googleAuthenticatorSecret): void
    {
        $this->googleAuthenticatorSecret = $googleAuthenticatorSecret;
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): self
    {
        $this->activation_token = $activation_token;

        return $this;
    }

    public function getNotifyAddCoach(): ?string
    {
        return $this->notifyAddCoach;
    }

    public function setNotifyAddCoach(string $notifyAddCoach): self
    {
        $this->notifyAddCoach = $notifyAddCoach;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
    function construct($id,$nom,$prenom,$email,$password,$tel,$specialite,$adresse,$role,$roles,$picture) {
        $this->setId($id);
        $this->setNom($nom);
        $this->SetPrenom($prenom);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setAdresse($adresse);
        $this->setTel($tel);
        $this->setSpecialite($specialite);
        $this->setPicture($picture);
        $this->setRole($role);
        $this->setRoles($roles);


    }

}
