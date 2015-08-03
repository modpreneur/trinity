<?php

namespace Trinity\FrameworkBundle\Bundle;

use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
    use Trinity\FrameworkBundle\BundleProcessor;
    use Trinity\FrameworkBundle\Event\StatusBundleEvent;
    use Trinity\FrameworkBundle\Event\TrinityEvents;
    use Trinity\FrameworkBundle\Utils\Cache;

    class BundleManager
    {
        /** @var  TraceableEventDispatcher */
        private $event_dispatcher;

        /**
         * @var Cache
         */
        private $cache;

        public function __construct(TraceableEventDispatcher $event_dispatcher, Cache $cache)
        {
            $this->event_dispatcher = $event_dispatcher;
            $this->cache = $cache;
        }

        /**
         * @param $bundlePath string
         * $bundlePath is Bundle name with namespace
         */
        public function disableBundle($bundlePath)
        {
            BundleProcessor::disableBundle($bundlePath);
            $sbe = new StatusBundleEvent('disable', $bundlePath);
            $this->event_dispatcher->dispatch(TrinityEvents::STATUS_BUNDLE_EVENT, $sbe);

            //@todo
            $this->cache->removeCache();
        }

        /**
         * @param $bundlePath string
         * $bundlePath is Bundle name with namespace
         */
        public function activeBundle($bundlePath)
        {
            BundleProcessor::activeBundle($bundlePath);
            $sbe = new StatusBundleEvent('active', $bundlePath);
            $this->event_dispatcher->dispatch(TrinityEvents::STATUS_BUNDLE_EVENT, $sbe);

            //@todo
            $this->cache->removeCache();
        }

        /**
         * @todo loading bundles.
         *
         * @return array
         */
        public function getBundleList()
        {
            return [
                'Necktie\\AppBundle\\NecktieAppBundle',
                'Necktie\\ClickBankBundle\\NecktieClickBankBundle',
                'Necktie\\LoggerBundle\\NecktieLoggerBundle',
                'Necktie\\FOSUserFixBundle\\NecktieFOSUserFixBundle',
                'Necktie\\SSOBundle\\NecktieSSOBundle',
                'Necktie\\NotificationBundle\\NecktieNotificationBundle',
                'Necktie\\AdminBundle\\NecktieAdminBundle',
            ];
        }
    }
