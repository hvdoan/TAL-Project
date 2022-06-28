<?php

namespace App\Model;

use App\Core\Sql;

class BanWord extends Sql{
    protected $id = null;
    protected $message = null;
    protected $creationDate = null;
    protected $updateDate = null;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param null $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return null
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param string
     */
    public function creationDate(): void {
        $this->creationDate = date("Y-m-d H:i:s");
    }

    /**
     * @return null
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @param string
     */
    public function updateDate(): void {
        $this->updateDate = date("Y-m-d H:i:s");
    }

}