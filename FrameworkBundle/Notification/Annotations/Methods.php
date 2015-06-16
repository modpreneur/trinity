<?php

    namespace Trinity\FrameworkBundle\Notification\Annotations;

    /**
     * Class Events
     * @author Tomáš Jančar
     * @Annotation
     *
     */
    class Methods
    {

        /** @var  array */
        protected $types;



        function __construct($metadata = array())
        {
            $this->types = (isset($metadata['types']) && $metadata['types'] != '') ? ($metadata['types']) : array();
        }



        /**
         * @return array
         */
        public function getTypes()
        {
            return $this->types;
        }



        /**
         * @param $typeName
         * @return bool
         */
        public function hasType($typeName)
        {
            return in_array(strtolower($typeName), $this->getTypes());
        }

    }