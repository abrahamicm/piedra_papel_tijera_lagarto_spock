<?php

namespace Uniqoders\Game\Models;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Question\ChoiceQuestion;

class Juego
{

    protected array $armas;
    protected array $reglas;
    protected int $round;
    protected int $max_round = 5;

    const GANAJUGADOR = 1;
    const GANACOMPUTADORA = 2;
    const EMPATE = 3;


    public function __construct()
    {
        $this->armas = [];
        $this->reglas = [];
        $this->round = 1;
        $this->max_round = 5;
        $this->arma = "";
    }

    /**
     * @return array
     */
    public function getArmas()
    {
        return $this->armas;
    }

    /**
     * @param array $armas
     */
    public function agregaArma($armas)
    {
        $this->armas[] = strtoupper($armas);
    }

    /**
     * @return int
     */
    public function getRound()
    {
        return $this->round;
    }


    public function aumentaRound()
    {
        $this->round++;
    }

    /**
     * @return int
     */
    public function getMaxRound()
    {
        return $this->max_round;
    }

    /**
     * @param int $max_round
     */
    public function setMaxRound($max_round)
    {
        $this->max_round = $max_round;
    }

    /**
     * @return array
     */
    public function getReglas()
    {
        return $this->reglas;
    }

    /**
     * @param string $arma
     * @param array $le_gana_a
     */
    public function addRegla(string $arma, array $le_gana_a)
    {
        $arma_upper = strtoupper($arma);
        $array_upper = array_map('strtoupper', $le_gana_a);

        $this->reglas[$arma_upper] = $array_upper;
    }



    public function quien_gana(string $arma_jugador, string $arma_computadora)
    {


        $arma_computadora = strtoupper($arma_computadora);
        $arma_jugador = strtoupper($arma_jugador);
        $gana_jugador = false;
        $gana_computadora = false;



        if (in_array($arma_jugador, array_keys($this->reglas))) {

            $gana_jugador = in_array($arma_computadora, $this->reglas[$arma_jugador]);
        } if (in_array($arma_computadora, array_keys($this->reglas))) {

            $gana_computadora = in_array($arma_jugador, $this->reglas[$arma_computadora]);
        }


        if ($gana_jugador) return 1;
        elseif ($gana_computadora) return 2;
        else return 3;


    }

    public function juego_esta_vigente($numero_victorias )
    {
        return $this->getRound() <= $this->getMaxRound() && $numero_victorias<3 ;
    }

    public function dar_bienvenida($output)
    {
        $output->write(PHP_EOL . 'Hecho con  ♥ por Uniqoders.' . PHP_EOL . PHP_EOL);
    }

    public function ofrecer_armas($ask,$input,$output,Jugador $jugador  )
    {

        $question = new ChoiceQuestion('Por favor selecciona tu arma', array_values($this->getArmas()), 1);
        $question->setErrorMessage('Weapon %s is invalid.');

        // Scissors|Rock|Paper
        $user_weapon = $ask->ask($input, $output, $question);

        $output->writeln('Tu elegiste: ' . $user_weapon);

        $jugador->setArma($user_weapon);

    }

    public function mostrar_estadisticas($output,Jugador  $jugador ,Computadora $computadora){
        $players=[$jugador,$computadora];
        $stats = $players;





        $stats = array_map(function ($player) {
            return [$player->getNombre(), $player->getVictorias(),  $player->getEmpates(),  $player->getDerrotas()];
        }, $stats);

        $table = new Table($output);
        $table
            ->setHeaders(['Jugador','Rondas ganadas','Rondas empatadas','Rondas perdidas'])
            ->setRows($stats);

        $table->render();

        return 0;
    }
}


