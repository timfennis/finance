<?php

declare(strict_types=1);

namespace Fennis\FinanceBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Fennis\FinanceBundle\Domain\Transaction;
use Fennis\FinanceBundle\Entity\Transaction as DoctrineTransaction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TransactionController.
 */
class TransactionController extends Controller
{
    /**
     * @Route(path="/", name="fennis_finance_home")
     * @Route(path="/transactions/")
     */
    public function indexAction()
    {
        $criteria = Criteria::create();
        $criteria->setMaxResults(100);
        $criteria->orderBy(['transactionDate' => Criteria::DESC]);

        /** @var Transaction[] $transactions */
        $transactions = $this->get('fennis_finance.repository.transaction_repository')->matching($criteria);

        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactions,
        ]);
    }

    /**
     * @Route(path="/transactions/{transaction}")
     *
     * @param DoctrineTransaction $transaction
     *
     * @return Response
     */
    public function showAction(DoctrineTransaction $transaction)
    {
        return $this->render('transaction/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }
}
