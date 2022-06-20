<?php
namespace App\Model;

use App\Core\Sql;

class TotalVisitor extends Sql
{
    protected $id = null;
    protected $session = null;
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
     * @return null|int
     */
    public function getSession(): ?int
    {
        return $this->session;
    }

    /**
     * @return null|int
     */
    public function getTime(): ?int
    {
        return $this->time;
    }

    /**
     * @param null|int
     */
    public function setSession($session): void
    {
        $this->session = $session;
    }

    /**
     * @param null|int
     */
    public function setTime($time): void
    {
        $this->time = $time;
    }
}