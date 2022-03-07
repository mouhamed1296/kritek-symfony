<?php

namespace App\Entity;

use App\Repository\InvoiceDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceDetailsRepository::class)]
class InvoiceDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'integer')]
    private ?int $invoice_id;

    #[ORM\Column(type: 'text', length: 255, nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'integer')]
    private ?int $quantity;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private ?string $amount;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private ?string $VAT_AMOUNT;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private ?string $total_after_vat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoiceId(): ?int
    {
        return $this->invoice_id;
    }

    public function setInvoiceId(int $invoice_id): self
    {
        $this->invoice_id = $invoice_id;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getVATAMOUNT(): ?string
    {
        return $this->VAT_AMOUNT;
    }

    public function setVATAMOUNT(string $VAT_AMOUNT): self
    {
        $this->VAT_AMOUNT = $VAT_AMOUNT;

        return $this;
    }

    public function getTotalAfterVat(): ?string
    {
        return $this->total_after_vat;
    }

    public function setTotalAfterVat(string $total_after_vat): self
    {
        $this->total_after_vat = $total_after_vat;

        return $this;
    }
}