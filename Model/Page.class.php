<?php

namespace App\Model;

use App\Core\Sql;

class Page extends Sql
{
    protected $id			        = null;
    protected $idUser               = null;
    protected $uri	                = null;
    protected $controller	        = null;
    protected $action	            = null;
    protected $description	        = null;
    protected $content  	        = null;
    protected $dateModification     = null;

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
     * @return null|string
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }

    /**
     * @param null|string
     */
    public function setUri(?string $uri): void
    {
        $this->uri = $uri;
    }

    /**
     * @return null|string
     */
    public function getController(): ?string
    {
        return $this->controller;
    }

    /**
     * @param null|string
     */
    public function setController(?string $controller): void
    {
        $this->controller = $controller;
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
     * @return null|string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param null|string
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return null|string
     */
    public function getDateModification(): ?string
    {
        return $this->dateModification;
    }

    /**
     * @param null|string
     */
    public function setDateModification(?string $dateModification): void
    {
        $this->dateModification = $dateModification;
    }
}