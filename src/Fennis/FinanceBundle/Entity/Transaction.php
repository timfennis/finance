<?php

declare(strict_types=1);

namespace Fennis\FinanceBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Fennis\FinanceBundle\Domain\Transaction as TransactionInterface;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Transaction.
 *
 * @author Tim Fennis <tim@isset.nl>
 * @ORM\Entity(repositoryClass="Fennis\FinanceBundle\Repository\DoctrineTransactionRepository")
 * @ORM\Table(name="transactions")
 */
class Transaction implements TransactionInterface
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="uuid_binary")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @var UuidInterface
     * @ORM\Column(type="uuid_binary", unique=true)
     */
    private $hash;

    /**
     * @var DateTime
     * @ORM\Column(type="date", nullable=false)
     */
    private $transactionDate;

    /**
     * @var BankAccountNumber
     * @ORM\Embedded(class="Fennis\FinanceBundle\Entity\BankAccountNumber")
     */
    private $affectedAccount;

    /**
     * @var BankAccountNumber
     * @ORM\Embedded(class="Fennis\FinanceBundle\Entity\BankAccountNumber")
     */
    private $otherAccount;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $code;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $amount;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $mutationType;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * Transaction constructor.
     *
     * @param DateTime $transactionDate
     * @param BankAccountNumber $affectedAccount
     * @param BankAccountNumber $otherAccount
     * @param string $name
     * @param string $code
     * @param Money $amount
     * @param string $mutationType
     * @param string $description
     */
    public function __construct(DateTime $transactionDate, BankAccountNumber $affectedAccount, BankAccountNumber $otherAccount, string $name, string $code, Money $amount, string $mutationType, string $description)
    {
        $this->transactionDate = $transactionDate;
        $this->affectedAccount = $affectedAccount;
        $this->otherAccount = $otherAccount;
        $this->name = $name;
        $this->code = $code;
        $this->amount = $amount->getAmount() / 100;
        $this->mutationType = $mutationType;
        $this->description = $description;
        $this->hash = $this->hash();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return UuidInterface
     */
    public function getHash(): UuidInterface
    {
        return $this->hash;
    }

    /**
     * @return DateTime
     */
    public function getTransactionDate(): DateTime
    {
        return $this->transactionDate;
    }

    /**
     * @return BankAccountNumber
     */
    public function getAffectedAccount(): BankAccountNumber
    {
        return $this->affectedAccount;
    }

    /**
     * @return BankAccountNumber
     */
    public function getOtherAccount(): BankAccountNumber
    {
        return $this->otherAccount;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return Money::EUR($this->amount * 100);
    }

    /**
     * @return string
     */
    public function getMutationType(): string
    {
        return $this->mutationType;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    private function hash(): UuidInterface
    {
        return Uuid::uuid5(TransactionInterface::TRANSACTION_NS,
            $this->transactionDate->format('Y-m-d') .
            $this->affectedAccount->getNumber()->getOrElse('0') .
            $this->otherAccount->getNumber()->getOrElse('0') .
            $this->name .
            $this->code .
            $this->amount .
            $this->mutationType .
            $this->description
        );
    }
}
