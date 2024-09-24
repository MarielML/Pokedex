<?php

function mostrarPokemon($pokemon)
{
    echo '<td class="border border-gray-400 p-2">
             <a href="pokemon.php?id=' . htmlspecialchars($pokemon['id']) . '">';
    if ($pokemon["imagen"] == "Sin imagen") {
        echo 'Sin imagen';
    } else {
        echo '<img src="' . htmlspecialchars($pokemon['imagen']) . '" alt="imagen">';
    }
    echo '</a>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <a href="pokemon.php?id=' . htmlspecialchars($pokemon['id']) . '">
                            <img src="' . htmlspecialchars($pokemon['tipo']) . '" alt="tipo">
                        </a>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <a href="pokemon.php?id=' . htmlspecialchars($pokemon['id']) . '">' . htmlspecialchars($pokemon['numero']) . '</a>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <a href="pokemon.php?id=' . htmlspecialchars($pokemon['id']) . '">' . htmlspecialchars($pokemon['nombre']) . '</a>
                    </td>';
}

function mostrarAccionesDeLogeado($id)
{
        echo '<td>
            <div class="acciones">
                                <a href="modificar.php?id=' . htmlspecialchars($id) . '">
                                    <button>Modificación</button>
                                </a>
                                <form action="baja.php?id=' . htmlspecialchars($id) . '" onsubmit="confirmarEliminacion(event)" method="post">
                                    <button type="submit">Baja</button>
                                    
                                </form>
                                </div>
                            </td>';
}
function mostrarAccionesSiEstaLogeado()
{
    echo '<th>
                        Acciones
                    </th>';
}
function mostrarCuerpoDeTablaAdministrador($pokemons)
{
    foreach ($pokemons as $pokemon) {
        echo '<tr>';
        mostrarPokemon($pokemon);
        mostrarAccionesDeLogeado($pokemon['id']);
        echo '</tr>';
    }

}
function mostrarTablaCliente($pokemons)
{
    foreach ($pokemons as $pokemon) {
        echo '<tr>';
        //-> muestra a los pokemon
        mostrarPokemon($pokemon);
        echo '</tr>';
    }

}
function mostrarBotonAgregarPokemon()
{
    echo'
<div class="agregar">
         <a href="./agregar.php"><button>Agregar pokemon</button></a>
</div>';
}