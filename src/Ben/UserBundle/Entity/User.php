<?php

namespace Ben\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable as JoinTable;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * User
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     * @Groups("detail")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     * @Expose
     * @Groups("detail")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     * @Expose
     * @Groups("detail")
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=255, nullable=true)
     * @Expose
     * @Groups("detail")
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     * @Expose
     * @Groups("detail")
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     * @Expose
     * @Groups("detail")
     */
    private $address;
    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="friends")
     */
    protected $friendsWith;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="friendsWith")
     * @JoinTable(name="friends",
     *            joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *            inverseJoinColumns={@JoinColumn(name="friend_user_id", referencedColumnName="id")}
     *           )
     */
    protected $friends;


    /************ constructeur ************/

    public function __construct()
    {
        parent::__construct();
        $this->friends = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /************ getters & setters  ************/

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return User
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add friendsWith
     *
     * @param \Ben\UserBundle\Entity\User $friendsWith
     *
     * @return User
     */
    public function addFriendsWith(\Ben\UserBundle\Entity\User $friendsWith)
    {
        $this->friendsWith[] = $friendsWith;

        return $this;
    }

    /**
     * Remove friendsWith
     *
     * @param \Ben\UserBundle\Entity\User $friendsWith
     */
    public function removeFriendsWith(\Ben\UserBundle\Entity\User $friendsWith)
    {
        $this->friendsWith->removeElement($friendsWith);
    }

    /**
     * Get friendsWith
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriendsWith()
    {
        return $this->friendsWith;
    }

    /**
     * Add friend
     *
     * @param \Ben\UserBundle\Entity\User $friend
     *
     * @return User
     */
    public function addFriend(\Ben\UserBundle\Entity\User $friend)
    {
        $this->friends[] = $friend;

        return $this;
    }

    /**
     * Remove friend
     *
     * @param \Ben\UserBundle\Entity\User $friend
     */
    public function removeFriend(\Ben\UserBundle\Entity\User $friend)
    {
        $this->friends->removeElement($friend);
    }

    /**
     * Get friends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriends()
    {
        return $this->friends;
    }

    public function isFriendWith(\Ben\UserBundle\Entity\User $friend)
    {
        return $this->friends->contains($friend) ;
    }
}
