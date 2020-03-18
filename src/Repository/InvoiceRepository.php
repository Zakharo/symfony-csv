<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class InvoiceRepository extends ServiceEntityRepository
{
    private const COEF_05 = 0.5;
    private const COEF_03 = 0.3;

    /**
     * InvoiceRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoice::class);
    }

    /**
     * @param array $row
     * @return Invoice
     */
    public function generateInvoice(array $row)
    {
        $now = new \DateTime('now');
        $date = new \DateTime($row[2]);
        $diffDays = $now->diff($date)->days;

        if ($diffDays > 30) {
            $price = $row[1] * self::COEF_05;
        } else {
            $price = $row[1] * self::COEF_03;
        }

        $invoice = (new Invoice())
            ->setIdentifier(trim($row[0]))
            ->setAmount(trim($row[1]))
            ->setDate($date)
            ->setPrice($price);

        return $invoice;
    }
}
