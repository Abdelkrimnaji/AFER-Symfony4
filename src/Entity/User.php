<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields={"email"},
 * message="L'email que vous avez indiqué est déjà utilisé !"
 * )
 * @UniqueEntity(
 * fields={"username"},
 * message="Le nom d'utilisateur que vous avez indiqué est déjà utilisé !"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message = "L'adresse email saisie n'est pas valide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 2, max = 255, minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     * @Assert\Regex(pattern = "/^[a-zA-Zàâçéèêëîïôûùüÿñæœ .-]*$/i", match = true, message = "{{ value }} contient un caractère non autorisé")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 2, max = 255, minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     * @Assert\Regex(pattern = "/^[a-zA-Zàâçéèêëîïôûùüÿñæœ .-]*$/i", match = true, message = "{{ value }} contient un caractère non autorisé")
     */
    private $nomUser;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 2, max = 255, minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     * @Assert\Regex(pattern = "/^[a-zA-Zàâçéèêëîïôûùüÿñæœ .-]*$/i", match = true, message = "{{ value }} contient un caractère non autorisé")
     */
    private $prenomUser;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Le mot de passe doit contenir au minimum 8 caractères")
     * @Assert\Regex(pattern = "/\d/", match = true, message = "Le mot de passe doit contenir un chiffre")
     * @Assert\Regex(pattern = "/[^A-Za-z0-9]/", match = true, message = "Le mot de passe doit contenir un caractère spécial")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas tapé le même mot de passe")
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $roles = [];

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }

    public function setNomUser(string $nomUser): self
    {
        $this->nomUser = $nomUser;

        return $this;
    }

    public function getPrenomUser(): ?string
    {
        return $this->prenomUser;
    }

    public function setPrenomUser(string $prenomUser): self
    {
        $this->prenomUser = $prenomUser;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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
    /**
     * Returns the roles or permissions granted to the user for security.
     */
    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles(array $roles) 
    {
        $this->roles = $roles;

    }
    // public function setRoles(array $roles)
    // {
    //     $this->roles = $roles;
    // }
    // /**
    //  * Returns the salt that was originally used to encode the password.
    //  *
    //  * {@inheritdoc}
    //  */
    public function getSalt()
    {
        return null;
        // See "Do you need to use a Salt?" at http://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one
    }
    /**
     * Removes sensitive data from the user.
     *
    //  * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        // if you had a plainPassword property, you'd nullify it here
        // $this->plainPassword = null;
    }

    public function __toString()
    {
        return $this->getUsername();
    }
}


