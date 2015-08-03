<?php

namespace Trinity\FrameworkBundle\Tests;

use Trinity\FrameworkBundle\BundleProcessor;

class BundleProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testInstalledBundle()
    {
        $array = ['ABundle', 'BBundle', 'CBundle', 'DBundle'];
        $bundles = (BundleProcessor::getInstalledBundles([__DIR__.'/bundles']));

        $this->assertArray($bundles, $array);
    }

    public function testLoadYml()
    {
        $array = ['Trinity\\Test\\ABundle\\TrinityTestABundle', 'BBundle', 'DBundle'];
        $bundles = BundleProcessor::getActivedBundles(__DIR__.'/trinity/bundles.yml');

        $this->assertArray($array, $bundles);
    }

    public function testBundleList()
    {
        $array = BundleProcessor::getBundleList(__DIR__.'/trinity/bundles.yml', [__DIR__.'/bundles']);

        $data = [
            [
                'id' => 1,
                'path' => 'Trinity\\Test\\ABundle\\TrinityTestABundle',
                'name' => 'ABundle',
                'status' => 'Active',
                'active' => true,
            ],
            [
                'id' => 2,
                'path' => 'BBundle',
                'name' => 'BBundle',
                'status' => 'Active',
                'active' => true,
            ],
            [
                'id' => 3,
                'path' => '', // no path in bundles.yml
                'name' => 'CBundle',
                'status' => 'Disable',
                'active' => false,
            ],
            [
                'id' => 4,
                'path' => 'DBundle',
                'name' => 'DBundle',
                'status' => 'Active',
                'active' => true,
            ],
        ];

        $this->assertArray($array, $data);
    }

    private function assertArray(array $a, array $b)
    {
        $aa = [];
        $bb = [];

        foreach ($a as $item) {
            $aa[] = $item;
        }
        foreach ($b as $item) {
            $bb[] = $item;
        }

        $this->assertEquals(json_encode(arsort($aa)), json_encode(arsort($bb)));
    }
}
