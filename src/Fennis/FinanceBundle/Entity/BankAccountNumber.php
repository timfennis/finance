<?php

declare(strict_types=1);

namespace Fennis\FinanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IBAN\Validation\IBANValidator;
use InvalidArgumentException;
use PhpOption\Option;

/**
 * Class BankAccount.
 *
 * @author Tim Fennis <tim@isset.nl>
 * @ORM\Embeddable()
 */
class BankAccountNumber
{
    private const TYPE_UNKNOWN = 'unkown';
    private const TYPE_IBAN = 'iban';
    private const TYPE_EMPTY = 'empty';

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $number;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * BankAccount constructor.
     *
     * @param string $number
     * @param string $type
     */
    private function __construct(?string $number, string $type = self::TYPE_UNKNOWN)
    {
        $this->number = $number;
        $this->type = $type;
    }

    public function isIban()
    {
        return $this->type === self::TYPE_IBAN;
    }

    /**
     * @return Option
     */
    public function getNumber(): Option
    {
        return Option::fromValue($this->number);
    }

    public static function none()
    {
        return new self(null, self::TYPE_EMPTY);
    }

    public static function fromIban(string $ibanNumber): BankAccountNumber
    {
        if (false === self::isValidIban($ibanNumber)) {
            throw new InvalidArgumentException($ibanNumber . ' is not a valid IBAN');
        }

        return new self($ibanNumber, self::TYPE_IBAN);
    }

    public static function fromString(string $number)
    {
        if ($number === null || $number === '') {
            return self::none();
        }

        if (self::isValidIban($number)) {
            return self::fromIban($number);
        }

        return new self($number);
    }

    public static function isValidIban(string $ibanNumber)
    {
        static $ibanValidator = null;
        $ibanValidator = $ibanValidator ?: new IBANValidator();

        return $ibanValidator->validate($ibanNumber);
    }
}
