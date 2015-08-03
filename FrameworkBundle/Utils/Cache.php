<?php

namespace Trinity\FrameworkBundle\Utils;

class Cache
{
    /** @var  string */
    protected $cacheDir;

    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * @param bool $rename
     *
     * if rename is true -> add datetime to name of folder.
     */
    public function removeCache($rename = false)
    {
        if ($rename) {
            rename($this->cacheDir, $this->cacheDir.'-'.date('Y-m-d_H:i:s'));
        } else {
            $this->rrmdir($this->cacheDir);
        }
    }

    /**
     * @param $dir string
     *
     * dir path
     */
    private function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (filetype($dir.DIRECTORY_SEPARATOR.$object) == 'dir') {
                        $this->rrmdir($dir.DIRECTORY_SEPARATOR.$object);
                    } else {
                        unlink($dir.DIRECTORY_SEPARATOR.$object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}
