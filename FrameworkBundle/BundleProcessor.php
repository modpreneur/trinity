<?php

    namespace Trinity\FrameworkBundle;

    use Symfony\Component\Finder\Finder;
    use Symfony\Component\Yaml\Dumper;
    use Symfony\Component\Yaml\Parser;

    // rename
    class BundleProcessor
    {
        const ROOT            = __DIR__ . '/../../..';
        const TRINITY_BUNDLES = self::ROOT . '/trinity/bundles.yml';
        const SOURCE          = self::ROOT . '/src';


        private static function parseYML(){
            $yml = new Parser();
            $values = $yml->parse(file_get_contents(self::TRINITY_BUNDLES));

            return $values;
        }



        /**
         * @return Finder
         */
        private static function getFinder(){
            $finder     = new Finder();
            $finder->files()
                ->in(self::SOURCE . "/Necktie")
                ->in(self::SOURCE . "/Trinity")
                ->name('*Bundle.php');

            return $finder;
        }



        /**
         *
         * Return names of bundle without namespace (File name)
         *
         * @return array
         */
        private static function getInstalledBundles(){
            $installedBundles = [];
            foreach(self::getFinder() as $file){
                /** @var $file \Symfony\Component\Finder\SplFileInfo */
                $installedBundles[] = $file->getRelativePath();
            }
            return $installedBundles;
        }



        /**
         * Return names of bundle with namespace
         * load from trinity/bundles.yml
         *
         * @return array
         */
        private static function getActiveBundles(){
            $activeBundles = [];
            $values = self::parseYML();

            if(isset($values["bundles"])){
                $activeBundles = $values["bundles"];
            }

            return $activeBundles;
        }



        /**
         * Return bundles classes
         *
         * @return array
         */
        public static function loadBundles(){
            return self::prepareBundlesList(self::getActiveBundles(), self::getFinder());
        }



        /**
         * @return array[id, name, status]
         */
        public static function getBundleList(){
            $bundles = [];
            $activeBundles    = self::getActiveBundles();
            $installedBundles = self::getInstalledBundles();

            $id = 0;

            foreach($installedBundles as $ib){

                $status = "Disable";
                $path   = "";

                foreach($activeBundles as $ab){
                    $ex = explode("\\", $ab);
                    if($ib == $ex[count($ex) - 1] || "Necktie" . $ib == $ex[count($ex) - 1] ){
                        $status = "Active";
                        $path = $ab;
                    }
                }

                $bundles[] = [
                    "id"     => ++$id,
                    "path"   => $path,
                    "name"   => $ib,
                    "status" => $status,
                    "active" => ($status == "Active")
                ];
            }

            return $bundles;
        }


        public static function disableBundle($bundlePath){
            $values  = self::parseYML();
            if(($key = array_search($bundlePath, $values["bundles"])) !== false) {
                unset($values["bundles"][$key]);
            }

            $dumper = new Dumper();
            $dump = $dumper->dump($values, 2);
            file_put_contents(self::TRINITY_BUNDLES, $dump);
        }


        /**
         * @param $activeBundles
         * @param $finder
         * @return array
         */
        private static function prepareBundlesList($activeBundles, $finder){
            $bundles = [];
            $ac = self::getActiveBundles();
            foreach($ac as $b){
                $bundles[] = new $b();
            }
            return $bundles;
        }



        public static function activeBundle($bundlePath)
        {
            $values  = self::parseYML();
            $values["bundles"][] = $bundlePath;

            $dumper = new Dumper();
            $dump = $dumper->dump($values, 2);
            file_put_contents(self::TRINITY_BUNDLES, $dump);
        }

    }
