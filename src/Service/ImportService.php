<?php

namespace App\Service;

use App\Log\ImportLogger;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Exception;
use League\Csv\Reader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImportService
{
    /**
     * @var ImportLogger
     */
    private $logger;

    /**
     * @var ParameterBagInterface
     */
    private $parameters;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;

    /**
     * ImportService constructor.
     * @param ImportLogger $importLogger
     * @param ParameterBagInterface $parameterBag
     * @param EntityManagerInterface $em
     * @param InvoiceRepository $invoiceRepository
     */
    public function __construct(
        ImportLogger $importLogger,
        ParameterBagInterface $parameterBag,
        EntityManagerInterface $em,
        InvoiceRepository $invoiceRepository
    ) {
        $this->logger = $importLogger;
        $this->parameters = $parameterBag;
        $this->em = $em;
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * @param string $fileName
     */
    public function startImport(string $fileName)
    {
        try {
            $csv = $this->prepareCsvFile($fileName);
            $this->logger->info('Start import: ' . $fileName);
            foreach ($this->getCsvRecord($csv) as $row) {
                if ($this->isValidCsvRow($row)) {
                    $invoice = $this->invoiceRepository->generateInvoice($row);
                    $this->em->persist($invoice);
                }
            }

            $this->em->flush();
            $this->logger->info('Finish import: ' . $fileName);
        } catch (Exception $exception) {
            $this->logger->alert('Import not started. ' . $exception->getMessage());
        }
    }

    /**
     * @param string $fileName
     * @return Reader
     * @throws \League\Csv\Exception
     */
    private function prepareCsvFile(string $fileName)
    {
        $file = file_get_contents($this->parameters->get('csv_directory') . '/' . $fileName);
        $csv = Reader::createFromString($file);
        $csv->setDelimiter(',');

        return $csv;
    }

    private function isValidCsvRow(array $record)
    {
        if (count($record) !== 3) {
            $this->logger->alert('Invalid csv row: '. implode(',', $record));
            return false;
        }

        return true;
    }

    private function getCsvRecord(Reader $csv)
    {
        foreach ($csv as $record) {
            yield $record;
        }
    }
}
