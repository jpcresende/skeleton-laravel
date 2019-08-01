<?php


namespace App\Core;


use Illuminate\Database\Eloquent\FactoryBuilder as MainFactory;
use Symfony\Component\Finder\Finder;

/**
 * Class Factory
 * @package App\Core
 */
class Factory extends MainFactory
{
    /**
     * @param array $paths
     * @return Factory
     */
    public function load($paths = [])
    {
        $factory = $this;
        foreach ($paths as $path) {
            if (is_dir($path)) {
                foreach (Finder::create()->files()->in($path) as $file) {
                    require $file->getRealPath();
                }
            }
        }
        return $factory;
    }
}
