<?php

namespace App\Twig;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @name \App\Twig\CustomsExtensions
 */
class CustomsExtensions extends AbstractExtension {
    public function getFunctions()
    {
        return [
          new TwigFunction('getLength', [$this, 'getLength'])
        ];
    }

    public function getLength(PersistentCollection $arrayCollection){
        $array = $arrayCollection->toArray();
        return count($array);
    }
}
