<?php

namespace App\Classe;

class Search
{
    private $string;
    private $categories;

    public function getString()
    {
        return $this->string;
    }

    public function setString($string)
    {
        $this->string = $string;
    }

    public function getCategorie()
    {
        return $this->categories;
    }

    public function setCategorie($categorie)
    {
        $this->categories = $categorie;
    }
}
