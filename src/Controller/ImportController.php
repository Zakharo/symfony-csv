<?php

namespace App\Controller;

use App\Service\ImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\KernelInterface;

class ImportController extends AbstractController
{
    private const CSV_EXTENSION = 'csv';
    private const LOG_FILE = '/import.log';

    /**
     * @Route("/", methods={"GET", "POST"}, name="invoice_import")
     * @param Request $request
     * @param ParameterBagInterface $parameterBag
     * @param ImportService $importService
     * @param KernelInterface $kernel
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function importAction(
        Request $request,
        ParameterBagInterface $parameterBag,
        ImportService $importService,
        KernelInterface $kernel
    ) {
        if ($request->getMethod() === 'POST') {
            $file = $request->files->get('csvFile');
            if ($file instanceof UploadedFile && $file->getClientOriginalExtension() === self::CSV_EXTENSION) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . self::CSV_EXTENSION;
                $file->move($parameterBag->get('csv_directory'), $newFilename);

                $importService->startImport($newFilename);
            } elseif ($file instanceof UploadedFile && $file->getClientOriginalExtension() !== self::CSV_EXTENSION) {
                throw new \Exception('Wrong extension');
            } else {
                throw new \Exception('File not found');
            }

            return $this->redirectToRoute('invoice_import');
        }

        $logFile = file_exists($kernel->getLogDir() . self::LOG_FILE) ?
            file_get_contents($kernel->getLogDir() . self::LOG_FILE) :
            null;

        return $this->render('import/import.html.twig', [
            'logFile' => trim($logFile)
        ]);
    }
}
