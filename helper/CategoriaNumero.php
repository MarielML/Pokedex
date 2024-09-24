<?php
include_once ("BaseDeDatos/pokemon.php");
class CategoriaNumero
{

    private $name;

    public function __construct()
    {
        $this->name="numero";
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
        return $pokemon->obtenerCoincidenciasDeNumero($textoBuscado);
    }

}