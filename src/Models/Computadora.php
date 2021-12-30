<?php

namespace Uniqoders\Game\Models;
class Computadora extends Player
{
    public function __construct()
    {
        $this->nombre="Computadora ";
    }

    public function elegir_arma_al_azar($armas, $output)
    {
        $indice = array_rand($armas);
        $armas_elegida =$armas[$indice];
        $this->setArma(strtoupper( $armas_elegida));
        $output->writeln('La computadora eligio: ' . $this->getArma());
    }
}
