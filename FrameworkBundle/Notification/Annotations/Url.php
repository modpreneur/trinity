<?php
    namespace Trinity\FrameworkBundle\Notification\Annotations;

    use Doctrine\Common\Annotations\AnnotationException;



    /**
     * Class Url
     * @author Tomáš Jančar
     * @Annotation
     *
     */
    class Url
    {

        /** @var  string */
        protected $postfix;

        /** @var  array */
        protected $methods = [];



        function __construct($metadata = array())
        {
            $this->postfix = null;

            if (isset($metadata['postfix']) && $metadata['postfix'] != '') {
                $this->postfix = $metadata['postfix'];
            }

            if ($this->postfix === null) {
                throw new AnnotationException("Annotation error: Url postfix is not set.");
            }

            $this->methods = (isset($metadata['methods']) && $metadata['methods'] != '') ? $metadata['methods'] : array();
        }



        /**
         * @return string
         */
        public function getPostfix()
        {
            return $this->postfix;
        }



        /**
         * @return array
         */
        public function getMethods()
        {
            return $this->methods;
        }



        /**
         * @return bool
         */
        public function isWithoutMethods()
        {
            return empty($this->getMethods()) || count($this->getMethods()) == 0;
        }



        /**
         * @param $method
         * @return bool
         */
        public function hasMethod($method)
        {
            if (empty($this->getMethods())) {
                return true;
            }

            return in_array(strtolower($method), $this->getMethods());
        }


    }