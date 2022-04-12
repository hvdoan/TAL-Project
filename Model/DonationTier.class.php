<?php

namespace App\Model;

use App\Core\Sql;

class DonationTier extends Sql
{
    protected $id               = null;
    protected $price            = null;
    protected $name             = null;
    protected $description      = null;

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
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
	
	/**
	 * @return null|int
	 */
	public function getPrice(): ?int
	{
		return $this->price;
	}
	
	/**
	 * @param null|int
	 */
	public function setPrice(?int $price): void
	{
		$this->price = $price;
	}
}