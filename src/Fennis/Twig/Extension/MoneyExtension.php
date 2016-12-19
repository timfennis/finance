<?php

declare(strict_types=1);

namespace Fennis\Twig\Extension;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Twig_Extension;

class MoneyExtension extends Twig_Extension
{
    /**
     * @var IntlMoneyFormatter
     */
    private $formatter;

    public function __construct()
    {
        $this->formatter = new IntlMoneyFormatter(new \NumberFormatter('nl_NL', \NumberFormatter::CURRENCY), new ISOCurrencies());
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('money', [$this, 'formatAmount'])
        ];
    }

    public function formatAmount(Money $money = null): string
    {
        return $this->formatter->format($money);
    }

}
