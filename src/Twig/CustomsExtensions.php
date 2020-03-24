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
          new TwigFunction('getLength', [$this, 'getLength']),
          new TwigFunction('phoneNumber', [$this, 'phoneNumber'])
        ];
    }

    public function getLength(PersistentCollection $arrayCollection){
        $array = $arrayCollection->toArray();
        return count($array);
    }

    public function phoneNumber(string $phoneNumber){
        return $phoneNumber[0] . $phoneNumber[1] . ' ' .
               $phoneNumber[2] . $phoneNumber[3] . ' ' .
               $phoneNumber[4] . $phoneNumber[5] . ' ' .
               $phoneNumber[6] . $phoneNumber[7] . ' ' .
               $phoneNumber[8] . $phoneNumber[9];
    }
}
