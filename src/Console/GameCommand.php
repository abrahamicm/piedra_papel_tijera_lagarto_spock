<?php

namespace Uniqoders\Game\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Uniqoders\Game\Models\Computadora;
use Uniqoders\Game\Models\Jugador;
use Uniqoders\Game\Models\Juego;



class GameCommand extends Command
{
    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('game')
            ->setDescription('New game: you vs computer')
            ->addArgument('name', InputArgument::OPTIONAL, 'what is your name?', 'Player 1');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $jugador = new Jugador();
        $juego = new Juego();
        $computadora = new Computadora();

        $juego->dar_bienvenida($output);

        $jugador->setNombre($input->getArgument('name')) ;

        $juego->setMaxRound(5);

        $juego->agregaArma("piedra");
        $juego->agregaArma("papel");
        $juego->agregaArma("tijera");
        $juego->agregaArma("lagarto");
        $juego->agregaArma("spock");

        $juego->addRegla("piedra", ["tijera", "lagarto"]);
        $juego->addRegla("papel", ["piedra", "spock"]);
        $juego->addRegla("tijera", ["lagarto", "papel"]);
        $juego->addRegla("lagarto", ["spock", "papel"]);
        $juego->addRegla("spock", ["piedra", "tijera"]);



        $ask = $this->getHelper('question');

        do {
            $juego->ofrecer_armas($ask,$input,$output,$jugador);
            $computadora->elegir_arma_al_azar($juego->getArmas(),$output);

            $quien_gana = $juego->quien_gana($jugador->getArma(), $computadora->getArma());

            if ($quien_gana == Juego::GANAJUGADOR) {
                $jugador->aumenta_victorias();
                $computadora->aumenta_derrotas();
                $output->writeln($jugador->getNombre() . ' Ganaste!');
            } elseif ($quien_gana == Juego::GANACOMPUTADORA) {
                $jugador->aumenta_derrotas();
                $computadora->aumenta_victorias();
                $output->writeln($jugador->getNombre() . ' Perdiste!');
            } else {
                $jugador->aumenta_empates();
                $computadora->aumenta_empates();
                $output->writeln(' Empate!');
            }

            $juego->aumentaRound();
        } while ($juego->juego_esta_vigente($jugador->getVictorias()));


        $juego->mostrar_estadisticas($output,$jugador,$computadora);
        return 0;
    }
}
