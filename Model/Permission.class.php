<?php

namespace App\Model;

use App\Core\Sql;

class Permission extends Sql
{
	protected $id		= null;
	protected $idRole	= null;
	protected $idAction	= null;
}