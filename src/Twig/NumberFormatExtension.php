<?php
declare(strict_types=1);
namespace Oc\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class NumberFormatExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter("number_format", function ($number, int $decimals = 0, string $decPoint = ".", string $thousandsSep = ",") {
                return number_format((float)$number, $decimals, $decPoint, $thousandsSep);
            }),
        ];
    }
}
