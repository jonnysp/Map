<?php


namespace Jonnysp\Map\ContaoManager;

use Jonnysp\Map\JonnyspMap;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;


class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(JonnyspMap::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setReplace(['map']),
        ];
    }
}
