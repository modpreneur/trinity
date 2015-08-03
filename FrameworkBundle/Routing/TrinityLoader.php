<?php

namespace Trinity\FrameworkBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
    use Symfony\Component\Routing\RouteCollection;

    class TrinityLoader extends Loader
    {
        /** @var string */
        public $type;

        /** @var  string */
        public $resource;

        /** @var bool */
        private $loaded = false;

        public function __construct($resource, $type = 'annotation')
        {
            $this->resource = $resource;
            $this->type = $type;
        }

        public function load($resource, $type = null)
        {
            if (true === $this->loaded) {
                throw new \RuntimeException('Do not add the "extra" loader twice.');
            }

            $collection = new RouteCollection();

            $resource = '@'.$this->resource;
            $type = $this->type;
            $importedRoutes = $this->import($resource, $type);

            $collection->addCollection($importedRoutes);

            $this->loaded = true;

            return $collection;
        }

        public function supports($resource, $type = null)
        {
            return 'extra' === $type;
        }
    }
