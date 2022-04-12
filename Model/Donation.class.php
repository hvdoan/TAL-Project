<?php

namespace App\Model;

use App\Core\Sql;

class Donation extends Sql
{
    protected $id	    = null;
    protected $idUser	= null;
    protected $amount	= null;
    protected $date	    = null;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|int
     */
    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    /**
     * @param null|int
     */
    public function setIdUser(?int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return null|int
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param null|int
     */
    public function setAmount(?int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return null|string
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param null|string
     */
    public function setDate(?string $date): void
    {
        $this->date = $date;
    }
}