<?php
namespace App\Model;

use App\Core\Sql;

class Log extends Sql
{
    protected $id = null;
    protected $idUser = null;
    protected $action = null;
    protected $time = null;


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
     * @param null|int
     */
    public function setIdUser(?int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return null|string
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * @param null|string
     */
    public function setAction(?string $action): void
    {
        $this->action = $action;
    }

    /**
     * @return null|string
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * @param null|string
     */
    public function setTime(): void
    {
        $this->time = time();
    }
}