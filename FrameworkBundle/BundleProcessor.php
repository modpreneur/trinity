<?php

    namespace Trinity\FrameworkBundle;

    use Symfony\Component\Finder\Finder;
    use Symfony\Component\Yaml\Dumper;
    use Symfony\Component\Yaml\Parser;

    // rename
    //@todo
    class BundleProcessor
    {

        private static function parseYML($ymlPath){
            $yml = new Parser();
            $values = $yml->parse(file_get_contents($ymlPath));

            return $values;
        }



        /**
         * @return Finder
         */
        private static function getFinder(array $sources){
            $finder     = new Finder();

            $finder = $finder->files();

            foreach($sources as $source){
                $finder = $finder->in($source);
            }

            $finder->name('*Bundle.php');
            return $finder;
        }



        /**
         *
         * Return names of bundle without namespace (File name)
         *
         * @return array
         */
        private static function getInstalledBundles($ymlDir, $sources){
            $installedBundles = [];
            foreach(self::getFinder($sources) as $file){
                /** @var $file \Symfony\Component\Finder\SplFileInfo */
                $installedBundles[] = $file->getRelativePath();
            }
            return $installedBundles;
        }



        /**
         * Return names of bundle with namespace
         * load from trinity/bundles.yml
         *
         * @param $ymlPath
         * @return array
         */
        private static function getActiveBundles($ymlPath){
            $activeBundles = [];
            $values = self::parseYML($ymlPath);

            if(isset($values["bundles"])){
                $activeBundles = $values["bundles"];
            }

            return $activeBundles;
        }



        /**
         * Return bundles classes
         * @param $ymlPath
         * @return array
         */
        public static function loadBundles($ymlPath, $sources){
            return self::prepareBundlesList(self::getActiveBundles($ymlPath), self::getFinder($sources), $ymlPath);
        }



        /**
         * @param $ymlPath
         * @return array [id, name, status]
         */
        public static function getBundleList($ymlPath, $sources){
            $bundles = [];
            $activeBundles    = self::getActiveBundles($ymlPath);
            $installedBundles = self::getInstalledBundles($ymlPath, $sources);

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


        public static function disableBundle($bundlePath, $ymlPath){
            $values  = self::parseYML($ymlPath);
            if(($key = array_search($bundlePath, $values["bundles"])) !== false) {
                unset($values["bundles"][$key]);
            }

            $dumper = new Dumper();
            $dump = $dumper->dump($values, 2);
            file_put_contents($ymlPath, $dump);
        }



        /**
         * @param $activeBundles
         * @param $finder
         * @param $ymlPath
         * @return array
         */
        private static function prepareBundlesList($activeBundles, $finder, $ymlPath){
            $bundles = [];
            $ac = self::getActiveBundles($ymlPath, $ymlPath);
            foreach($ac as $b){
                $bundles[] = new $b();
            }
            return $bundles;
        }



        public static function activeBundle($bundlePath, $ymlPath)
        {
            $values  = self::parseYML($ymlPath);
            $values["bundles"][] = $bundlePath;

            $dumper = new Dumper();
            $dump = $dumper->dump($values, 2);
            file_put_contents($ymlPath, $dump);
        }

    }
