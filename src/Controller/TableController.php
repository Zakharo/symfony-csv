<?php

namespace App\Controller;

use App\Repository\InvoiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/table")
 * Class TableController
 * @package App\Controller
 */
class TableController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="invoice_table")
     * @param InvoiceRepository $invoiceRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function importAction(
        InvoiceRepository $invoiceRepository
    ) {
        return $this->render('table/index.html.twig', [
            'invoices' => $invoiceRepository->findAll()
        ]);
    }
}
