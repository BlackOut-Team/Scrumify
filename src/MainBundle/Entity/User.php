<?php

namespace MainBundle\Entity;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;


/**
 * User
 * @package MainBundle\Entity
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\UserRepository")
 * @Notifiable(name="Meetings")
 */
class User extends BaseUser implements ParticipantInterface,NotifiableInterface
{
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

    public function __construct(){
        parent::__construct(); //Call parents constructor
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Ajouter une image jpg")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $image;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }


    /**
     * Overriding Fos User class due to impossible to set default role ROLE_USER
     * @see User at line 138
     * @link https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Model/User.php#L138
     * {@inheritdoc}
     */
    public function addRole($role)
    {
        $role = strtoupper($role);

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }




}

