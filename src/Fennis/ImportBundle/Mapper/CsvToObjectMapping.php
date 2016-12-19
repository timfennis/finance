<?php

declare(strict_types=1);

namespace Fennis\ImportBundle\Mapper;

use Fennis\FinanceBundle\Entity\BankAccountNumber;
use Fennis\FinanceBundle\Entity\Transaction;
use Money\Currencies\ISOCurrencies;
use Money\Exception\ParserException;
use Money\Parser\DecimalMoneyParser;
use Money\Parser\IntlMoneyParser;
use NumberFormatter;

/**
 * Class CsvToObjectMapping.
 *
 * @author Tim Fennis <tim@isset.nl>
 */
class CsvToObjectMapping
{
    public function __construct()
    {
        $this->moneyParser = new DecimalMoneyParser(new ISOCurrencies());
    }

    public function __invoke($data)
    {
        return $this->convert($data);
    }

    private function convert($data)
    {
        try {
            $amount = $this->moneyParser->parse(str_replace(',', '.', $data[6]), 'EUR');
            if ($data[5] === 'Af') {
                $amount = $amount->subtract($amount)->subtract($amount);
            }

            return new Transaction(
                \DateTime::createFromFormat('Ymd', $data[0]),
                BankAccountNumber::fromString($data[2]),
                BankAccountNumber::fromString($data[3]),
                $data[1],
                $data[4],
                $amount,
                $data[7],
                $data[8]
            );
        } catch (ParserException|\InvalidArgumentException $e) {
            throw new MapperException($data, $e);
        }
    }
}
