<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CopyrightExtension extends AbstractExtension
{
    // public function getFilters(): array
    // {
    //     return [
    //         // If your filter generates SAFE HTML, you should add a third
    //         // parameter: ['is_safe' => ['html']]
    //         // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
    //         new TwigFilter('filter_name', [$this, 'doSomething']),
    //     ];
    // }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('copyright', [$this, 'get_copyright'], ['is_safe' => ['html']]),
        ];
    }

    public function get_copyright(?int $defaultYear=null): string
    {
        $currentYear = date('Y');

        $outputStr = "&copy; ";

        if (null != $defaultYear && $defaultYear < $currentYear)
        {
            $outputStr.= $defaultYear."-";
        }

        $outputStr.= $currentYear;
        $outputStr.= " - SuperCatalog 2000";


        return $outputStr;
    }
}