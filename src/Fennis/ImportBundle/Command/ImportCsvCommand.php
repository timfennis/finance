<?php

declare(strict_types = 1);

namespace Fennis\ImportBundle\Command;

use Doctrine\Common\Persistence\ObjectManager;
use Fennis\FinanceBundle\Domain\Transaction;
use Fennis\FinanceBundle\Repository\TransactionRepository;
use Fennis\ImportBundle\Mapper\CsvToObjectMapping;
use Fennis\ImportBundle\Mapper\MapperException;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportCsvCommand.
 *
 * @author Tim Fennis <tim@isset.nl>
 */
class ImportCsvCommand extends Command
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository, ObjectManager $objectManager)
    {
        parent::__construct('import:csv');
        $this->transactionRepository = $transactionRepository;
        $this->objectManager = $objectManager;
    }

    protected function configure()
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'The file you want to import');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>></info> Reading file: ' . $input->getArgument('file'));
        $csv = Reader::createFromPath($input->getArgument('file'));
        $csv = $csv->fetch(new CsvToObjectMapping());

        $csv->rewind();
        while ($csv->valid()) {
            try {
                /** @var Transaction $transaction */
                $transaction = $csv->current();

                $this->transactionRepository->findOneByHash($transaction->getHash())
                    ->getOrCall(function () use ($transaction, $output) {
                        $this->transactionRepository->save($transaction);
                        $output->writeln('<info>></info> Found new transaction: ' . $transaction->getHash());
                        return $transaction;
                    });

            } catch (MapperException $exception) {
                $output->writeln('<error>Coun\'t parse record because: ' . $exception->getMessage() . '</error>');
            }

            $csv->next();
        }

        $this->objectManager->flush();
    }
}
