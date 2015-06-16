<?php


    namespace Trinity\FrameworkBundle\Notification\Annotations;

    /**
     * Class DisableNotification
     * @Annotation
     *
     * @author Tomáš Jančar
     */
    class Column
    {
        protected $name;



        function __construct($metadata = array())
        {
            $this->columns = (isset($metadata['name']) && $metadata['name'] != '') ? $metadata['name'] : "";
        }



        /**
         * @return bool
         */
        public function hasName()
        {
            return !empty($this->name);
        }



        /**
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

    }