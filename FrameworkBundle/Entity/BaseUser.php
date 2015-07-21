<?php

    namespace Trinity\FrameworkBundle\Entity;

    use Dmishh\Bundle\SettingsBundle\Entity\SettingsOwnerInterface;
    use Doctrine\ORM\Mapping as ORM;
    use FOS\UserBundle\Model\User;
    use Knp\DoctrineBehaviors\Model as ORMBehaviors;



    class BaseUser extends User implements SettingsOwnerInterface
    {
        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;

        /**
         * @var string
         * @ORM\Column(type="string", length=255, nullable=true)
         *
         */
        protected $firstName;

        /**
         * @var string
         * @ORM\Column(type="string", length=255, nullable=true)
         *
         */
        protected $lastName;

        /**
         * @var string
         * @ORM\Column(type="string", length=255, nullable=true)
         *
         */
        protected $phoneNumber;


        /**
         * @var string
         * @ORM\Column(type="string", length=255, nullable=true)
         *
         */
        protected $website;

        /**
         * @var string
         * @ORM\Column(type="string", length=255, nullable=true)
         *
         */
        protected $avatar;


        /**
         * @var boolean
         * @ORM\Column(type="boolean", nullable=true))
         *
         */
        protected $public = true;


        /**
         * @var string
         * @ORM\Column(type="string", length=2, nullable=true)
         *
         */
        protected $country;

        /**
         * @var string
         * @ORM\Column(type="string", length=32, nullable=true)
         *
         */
        protected $region;

        /**
         * @var string
         * @ORM\Column(type="string", length=32, nullable=true)
         *
         */
        protected $city;

        /**
         * @var string
         * @ORM\Column(type="string", length=255, nullable=true)
         *
         */
        protected $addressLine1;

        /**
         * @var string
         * @ORM\Column(type="string", length=255, nullable=true)
         *
         */
        protected $addressLine2;

        /**
         * @var string
         * @ORM\Column(type="string", length=6, nullable=true)N
         *
         */
        protected $postalCode;



        public function __construct()
        {
            parent::__construct();
            $this->roles = array('ROLE_USER');
            $this->enabled = true;
        }



        /**
         * Set firstName
         *
         * @param string $firstName
         * @return $this
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
         * @return $this
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
         * Get fullName
         *
         * @return string
         */
        public function getFullName()
        {
            if ($this->firstName && $this->lastName) {
                return "{$this->firstName} {$this->lastName}";
            } elseif ($this->firstName) {
                return $this->firstName;
            } elseif ($this->lastName) {
                return $this->lastName;
            } else {
                return '';
            }

        }



        /**
         * Set phoneNumber
         *
         * @param string $phoneNumber
         * @return $this
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
         * Get id
         *
         * @return integer
         */
        public function getId()
        {
            return $this->id;
        }



        /**
         * Set website
         *
         * @param string $website
         * @return $this
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
         * Set avatar
         *
         * @param string $avatar
         * @return $this
         */
        public function setAvatar($avatar)
        {
            $this->avatar = $avatar;

            return $this;
        }



        /**
         * Get avatar
         *
         * @return string
         */
        public function getAvatar()
        {
            return $this->avatar;
        }



        /**
         * Set public
         *
         * @param boolean $public
         * @return User
         */
        public function setPublic($public)
        {
            $this->public = $public;

            return $this;
        }



        /**
         * Get public
         *
         * @return boolean
         */
        public function getPublic()
        {
            return $this->public;
        }



        /**
         * Is Admin
         *
         * @return boolean
         */
        public function isAdmin()
        {
            return $this->hasRole('ROLE_ADMIN');
        }



        /**
         * Set Admin
         *
         * @param boolean $admin
         * @return User
         */
        public function setAdmin($admin)
        {
            if ($admin) {
                $this->addRole('ROLE_ADMIN');
            } else {
                $this->removeRole('ROLE_ADMIN');
            }

            return $this;
        }



        /**
         * @param string $addressLine1
         */
        public function setAddressLine1($addressLine1)
        {
            $this->addressLine1 = $addressLine1;
        }



        /**
         * @return string
         */
        public function getAddressLine1()
        {
            return $this->addressLine1;
        }



        /**
         * @param string $addressLine2
         */
        public function setAddressLine2($addressLine2)
        {
            $this->addressLine2 = $addressLine2;
        }



        /**
         * @return string
         */
        public function getAddressLine2()
        {
            return $this->addressLine2;
        }



        /**
         * @param string $city
         */
        public function setCity($city)
        {
            $this->city = $city;
        }



        /**
         * @return string
         */
        public function getCity()
        {
            return $this->city;
        }



        /**
         * @param string $country
         */
        public function setCountry($country)
        {
            $this->country = $country;
        }



        /**
         * @return string
         */
        public function getCountry()
        {
            return $this->country;
        }



        /**
         * @param string $postalCode
         */
        public function setPostalCode($postalCode)
        {
            $this->postalCode = $postalCode;
        }



        /**
         * @return string
         */
        public function getPostalCode()
        {
            return $this->postalCode;
        }



        /**
         * @param string $region
         */
        public function setRegion($region)
        {
            $this->region = $region;
        }



        /**
         * @return string
         */
        public function getRegion()
        {
            return $this->region;
        }



        /**
         * @return string
         */
        public function __toString()
        {
            return $this->username;
        }



        /**
         * @return int
         */
        public function getSettingIdentifier()
        {
            return $this->getId();
        }
    }
