<?php
include_once ("BaseDeDatos/pokemon.php");

class CategoriaNombre
{

    private $name;

    public function __construct()
    {
        $this->name="nombre";
    }

    public function apply($name)
    {
        if($this->name==$name){
            return true;
        }
        return false;
    }

    public function obtenerCoinciencias($textoBuscado,Pokemon $pokemon)
    {
        return $pokemon->obtenerCoincidenciasDeNombre($textoBuscado);
    }

}