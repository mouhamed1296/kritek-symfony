<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class InvoiceController extends AbstractController
{
    #[Route('/invoice', name: 'app_invoice', methods: ['GET'])]
    public function index(InvoiceRepository $repository): Response
    {
        $invoices = [];
        $data = $repository->findAll();
        $i = 0;
        foreach ($data as $item) {
            $invoices[$i]['number'] =  $item->getInvoiceNumber();
            $invoices[$i]['date'] = $item->getInvoiceDate()->format('Y-m-d');
            $invoices[$i]['cid'] = $item->getCustomerId();
            $invoices[$i]['id'] = $item->getId();
            $i++;
        }
        return $this->json($invoices);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @param HttpClientInterface $httpClient
     * @return Response
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    #[Route('/invoice/add', name: 'app_invoice_add', methods: ['POST'])]
    public function add(ManagerRegistry $doctrine, Request $request, InvoiceDetailsController $invoiceDetailsController): Response
    {
        $entityManager = $doctrine->getManager();
        $invoiceRequest = $request->request;
        $invoice = new Invoice();

        $invoice->setInvoiceDate(new DateTime());
        $invoice->setInvoiceNumber(2);
        $invoice->setCustomerId(25);

        $entityManager->persist($invoice);
        $entityManager->flush();
        $invoice_id = $invoice->getId();
        $invoiceRequest->set('invoice_id', $invoice_id);
        $response = $invoiceDetailsController->add($doctrine, $request);

        return $this->json('Invoice added with id: '.$invoice_id. ' ' .$response->getContent());
    }
}
