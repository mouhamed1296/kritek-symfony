<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'date')]
    private ?DateTimeInterface $invoice_date;

    #[ORM\Column(type: 'integer')]
    private ?int $invoice_number;

    #[ORM\Column(type: 'integer')]
    private ?int $customer_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoiceDate(): ?DateTimeInterface
    {
        return $this->invoice_date;
    }

    public function setInvoiceDate(DateTimeInterface $invoice_date): self
    {
        $this->invoice_date = $invoice_date;

        return $this;
    }

    public function getInvoiceNumber(): ?int
    {
        return $this->invoice_number;
    }

    public function setInvoiceNumber(int $invoice_number): self
    {
        $this->invoice_number = $invoice_number;

        return $this;
    }

    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    public function setCustomerId(int $customer_id): self
    {
        $this->customer_id = $customer_id;

        return $this;
    }
}
