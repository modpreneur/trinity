<?php

    namespace Trinity\FrameworkBundle\Event;

    use Symfony\Component\EventDispatcher\Event;



    class StatusBundleEvent extends Event
    {

        /** @var  string */
        protected $state;

        /** @var  string */
        protected $name;



        function __construct($state, $name)
        {
            $this->state = $state;
            $this->name = $name;
        }



        /**
         * @return string
         */
        public function getState()
        {
            return $this->state;
        }



        /**
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

    }