<?php

    namespace Trinity\FrameworkBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use JMS\Serializer\Annotation\SerializedName;
    use Knp\DoctrineBehaviors\Model as ORMBehaviors;
    use Trinity\FrameworkBundle\Notification\Annotations as Notify;



    /**
     * BaseProduct
     *
     *
     */
    class BaseProduct
    {
	    use
		    ORMBehaviors\Timestampable\Timestampable
		    ;

        /**
         * @var integer
         *
         * @ORM\Column(type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         *
         */
        protected $id;

        /**
         * @var string Name of the product
         * @ORM\Column(type="string", unique=true)
         *
         */
        protected $name;

        /**
         * @var string Description of the product
         * @ORM\Column(type="string", nullable = true)
         */
        protected $description;



        /**
         * Get id
         *
         * @return integer
         *
         */
        public function getId()
        {
            return $this->id;
        }



        /**
         * Set name
         *
         * @param string $name
         * @return BaseProduct
         */
        public function setName($name)
        {
            $this->name = $name;

            return $this;
        }



        /**
         * Get name
         *
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }



        /**
         * Set description
         *
         * @param string $description
         * @return BaseProduct
         */
        public function setDescription($description)
        {
            $this->description = $description;

            return $this;
        }


        /**
         * Get description
         *
         * @return string
         */
        public function getDescription()
        {
            return $this->description;
        }



        public function __toString()
        {
            return (string)$this->getName();
        }

    }
