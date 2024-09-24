<?php
include_once ("BaseDeDatos/pokemon.php");

class Categoriatipo
{

    private $name;

    public function __construct()
    {
        $this->name="tipo";
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
        return $pokemon->obtenerCoincidenciasDeTipo($textoBuscado);
    }

}