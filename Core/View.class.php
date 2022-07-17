<?php

namespace App\Core;

class View{
	private $view;
	private $template;
	private $data = [];
	private $theme;

	public function __construct($view, $template = "front")
	{
		$this->setView($view);
		$this->setTemplate($template);
        $file = 'Template/template.json';
        if (file_exists($file)) {
            $this->theme = json_decode(file_get_contents($file), true);
        } else {
            die('Fichier template introuvable');
        }
	}

	public function setView($view): void
	{
		$this->view = $view;
	}

	public function setTemplate($template): void
	{
		$this->template = strtolower($template);
	}

	public function __toString(): string
	{
		return "La vue est : " . $this->view;
	}

	public function includePartial($partial, $data): void
	{
		if(!file_exists("View/Partial/" . $partial . ".partial.php")){
			die("Le partial " . $partial . " n'existe pas");
		}
		include "View/Partial/" . $partial . ".partial.php";
	}

	/**
	 * @param $key
	 * @param $value
	 */
	public function assign($key, $value): void
	{
		$this->data[$key] = $value;
	}

	public function __destruct()
	{
		extract($this->data);
        if ($this->template === "front") {
            include "Template/" . $this->theme['template'] . "/View/" . $this->template . ".tpl.php";
        } else include "View/" . $this->template . ".tpl.php";

    }

}
