<?php

namespace App\Controller;

use App\Entity\InvoiceDetails;
use App\Repository\InvoiceDetailsRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceDetailsController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     */
    #[Route('/invoice/details/{id?0}', name: 'app_invoice_details', host: 'localhost', methods: ['GET'])]
    public function index(InvoiceDetailsRepository $repository, Request $request): Response
    {
        $id = (int) $request->get('id');
        $data = $repository->findOneByInvoiceId($id);
        return $this->json([
            'description' => $data->getDescription(),
            'quantity' => $data->getQuantity(),
            'amount' => $data->getAmount(),
            'vat' => $data->getVATAMOUNT(),
            'total' => $data->getTotalAfterVat()
        ]);
    }

    public function add (ManagerRegistry $doctrine, Request $request): Response {
        $entityManager = $doctrine->getManager();
        $invoiceDetailsRequest = $request->request;
        $quantity = $invoiceDetailsRequest->get('quantity');
        $invoice_id = $invoiceDetailsRequest->get('invoice_id');
        $amount = $invoiceDetailsRequest->get('amount');
        $description = $invoiceDetailsRequest->get('description');

        $invoiceDetails = new InvoiceDetails();
        $invoiceDetails->setQuantity($quantity);
        $invoiceDetails->setInvoiceId($invoice_id);
        $invoiceDetails->setAmount($amount);
        $invoiceDetails->setDescription($description);
        $invoiceDetails->setVATAMOUNT(0.18);
        $total = (($amount  * $invoiceDetails->getVATAMOUNT()) + $amount) * $quantity;
        $invoiceDetails->setTotalAfterVat($total);

        $entityManager->persist($invoiceDetails);
        $entityManager->flush();

        return $this->json('Details added with id: '.$invoiceDetails->getId());
    }
}
