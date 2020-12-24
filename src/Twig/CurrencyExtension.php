<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CurrencyExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('currency', [$this, 'currencyFormat']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('currency', [$this, 'currencyFormat']),
        ];
    }

    public function currencyFormat($value): float
    {
        return $value / 100;
    }
}
