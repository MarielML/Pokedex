<?php
include_once ("CategoriaNombreTipoNumero.php");
include_once ("Categoriatipo.php");
include_once ("CategoriaNumero.php");
include_once ("CategoriaNombre.php");
class Categoria
{
    private $categorias;

    public function __construct($categorias)
    {
        $this->categorias=$categorias;
    }

    public function obtenerCategoria($name)
    {
        foreach ($this->categorias as $categoria) {
            if($categoria->apply($name)){
                return $categoria;
            }
        }
        return Throw new SinTipoDeCategoria();
    }

}