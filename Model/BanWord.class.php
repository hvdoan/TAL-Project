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
     * @param null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
     * @param null $creationDate
     */
    public function setCreationDate($creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return null
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @param null $updateDate
     */
    public function setUpdateDate($updateDate): void
    {
        $this->updateDate = $updateDate;
    }

}