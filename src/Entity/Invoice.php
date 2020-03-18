<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="invoice")
 * @ORM\HasLifecycleCallbacks
 */
class Invoice extends BaseEntity
{
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identifier;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $amount;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $price;

    /**
     * @return null|string
     */
    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    /**
     * @param null|string $identifier
     * @return Invoice
     */
    public function setIdentifier(?string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @param null|string $amount
     * @return Invoice
     */
    public function setAmount(?string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     * @return Invoice
     */
    public function setDate(?\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param null|string $price
     * @return Invoice
     */
    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
