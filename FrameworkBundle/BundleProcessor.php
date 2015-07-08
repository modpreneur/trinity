<?php

namespace Trinity\FrameworkBundle;

use Doctrine\Common\Cache\PhpFileCache;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

// rename
//@todo
class BundleProcessor
{
    private static function endsWith($haystack, $needle)
    {
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }


    /**
     * Return array [bundles][...]
     *
     * @param $ymlPath
     * @return array
     */
    private static function parseYML($ymlPath)
    {
        $yml = new Parser();
        $values = $yml->parse(file_get_contents($ymlPath));

        return $values;
    }


    /**
     * @param array $sources
     * @return Finder
     */
    private static function getFinder(array $sources)
    {
        $finder = new Finder();

        $finder = $finder->files();

        foreach ($sources as $source) {
            $finder = $finder->in($source);
        }

        $finder->name('*Bundle.php');
        return $finder;
    }


    /**
     *
     * Return names of bundle without namespace (File name)
     *
     * @param $sources
     * @return array
     */
    public static function getInstalledBundles($sources)
    {
        $installedBundles = [];
        foreach (self::getFinder($sources) as $file) {
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
    public static function getActivedBundles($ymlPath)
    {
        $activeBundles = [];
        $values = self::parseYML($ymlPath);

        if (isset($values["bundles"])) {
            $activeBundles = $values["bundles"];
        }

        return $activeBundles;
    }


    /**
     * Return bundles classes
     * @param $ymlPath
     * @param $sources
     * @param $cacheDir
     * @return array
     */
    public static function loadBundles($ymlPath, $sources, $cacheDir)
    {
        $cache = new PhpFileCache($cacheDir);

        if (!$cache->contains("bundles")) {
            $loadedBundles = self::prepareBundlesList(self::getActivedBundles($ymlPath), self::getFinder($sources), $ymlPath);
            $cache->save("bundles", $loadedBundles);
        } else {
            $loadedBundles = $cache->fetch("bundles");
        }

        $loadedBundlesClass = [];

        foreach ($loadedBundles as $bundle) {
            $loadedBundlesClass[] = new $bundle();
        }

        return $loadedBundlesClass;
    }


    /**
     * @param $ymlPath
     * @param $sources
     * @return array [id, name, status]
     */
    public static function getBundleList($ymlPath, $sources)
    {
        $bundles = [];
        $activeBundles = self::getActivedBundles($ymlPath);
        $installedBundles = self::getInstalledBundles($sources);

        $id = 0;

        foreach ($installedBundles as $ib) {

            $status = "Disable";
            $path = "";

            foreach ($activeBundles as $ab) {
                $ex = explode("\\", $ab);
                if (self::endsWith($ex[count($ex) - 1], $ib)) {
                    $status = "Active";
                    $path = $ab;
                }
            }

            $bundles[] = [
                "id" => ++$id,
                "path" => $path,
                "name" => $ib,
                "status" => $status,
                "active" => ($status == "Active")
            ];
        }

        return $bundles;
    }


    public static function disableBundle($bundlePath, $ymlPath)
    {
        $values = self::parseYML($ymlPath);
        if (($key = array_search($bundlePath, $values["bundles"])) !== false) {
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
    private static function prepareBundlesList($activeBundles, $finder, $ymlPath)
    {
        $bundles = [];
        $ac = self::getActivedBundles($ymlPath);
        foreach ($ac as $bundle) {
            $bundles[] = $bundle; // edit
        }
        return $bundles;
    }


    public static function activeBundle($bundlePath, $ymlPath)
    {
        $values = self::parseYML($ymlPath);
        $values["bundles"][] = $bundlePath;

        $dumper = new Dumper();
        $dump = $dumper->dump($values, 2);
        file_put_contents($ymlPath, $dump);
    }

}
