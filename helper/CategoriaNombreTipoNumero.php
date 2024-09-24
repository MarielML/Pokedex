<?php
include_once ("BaseDeDatos/pokemon.php");
class CategoriaNombreTipoNumero
{

    private $name;

    public function __construct()
    {
        $this->name="nombreTipoNumero";
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
        return $pokemon->obtenerCoincidenciasDeTipoNombreNumero($textoBuscado);
    }


}