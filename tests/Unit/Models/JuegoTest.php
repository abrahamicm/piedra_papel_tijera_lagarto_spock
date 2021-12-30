<?php

namespace Models;

use Prophecy\Prophecy\ObjectProphecy;
use Uniqoders\Game\Models\Juego;
use PHPUnit\Framework\TestCase;
use Uniqoders\Game\Models\Jugador;

class JuegoTest extends TestCase
{

    protected $juego;

    protected function setUp(): void
    {
        $this->juego = new Juego();

    }


    public function test_juego_puede_setear_rondas()
    {
        $this->juego->setMaxRound(7);
        $max_rondas = $this->juego->getMaxRound();
        $this->assertTrue($max_rondas == 7);
    }

    public function test_juego_puede_agregar_armas()
    {
        $this->juego->agregaArma("piedra");
        $this->juego->agregaArma("papel");
        $this->juego->agregaArma("tijera");
        $this->juego->agregaArma("lagarto");
        $this->juego->agregaArma("spock");
        $esperado = ["PIEDRA", "PAPEL", "TIJERA", "LAGARTO", "SPOCK"];
        $actual = $this->juego->getArmas();
        $this->assertSame(array_diff($esperado, $actual), array_diff($actual, $esperado));
    }

    public function test_juego_puede_agregar_reglas()
    {
        $this->juego->addRegla("piedra", ["tijera", "lagarto"]);
        $this->juego->addRegla("papel", ["piedra", "spock"]);
        $this->juego->addRegla("tijera", ["lagarto", "papel"]);
        $this->juego->addRegla("lagarto", ["spock", "papel"]);
        $this->juego->addRegla("spock", ["piedra", "tijera"]);

        $esperado = [
            "PIEDRA" => ["TIJERA", "LAGARTO"],
            "PAPEL" => ["PIEDRA", "SPOCK"],
            "TIJERA" => ["LAGARTO", "PAPEL"],
            "LAGARTO" => ["SPOCK", "PAPEL"],
            "SPOCK" => ["PIEDRA", "TIJERA"]
        ];
        $actual = $this->juego->getReglas();


        $this->assertSame($esperado, $actual);

    }

    public function test_juego_puede_saber_quien_gana()
    {
        // 1 gana usuario 2 gana computadora 3 empate

        $this->preparar_juego();

        $gana_usuario = $this->juego->quien_gana("PIEDRA", "TIJERA");
        $gana_computadora = $this->juego->quien_gana("piedra", "spock");
        $gana_empate = $this->juego->quien_gana("papel", "papel");


        $this->assertEquals($gana_usuario, 1);
        $this->assertEquals($gana_computadora, 2);
        $this->assertEquals($gana_empate, 3);
    }

    public function test_juego_aumenta_round(){

            $this->juego->aumentaRound();
            $this->juego->aumentaRound();
            $this->assertEquals(3, $this->juego->getRound());

    }

    public function test_juego_esta_vigente_round(){
        $vigente = $this->juego->juego_esta_vigente(1);
        $this->assertTrue($vigente);

        $this->juego->aumentaRound();
        $this->juego->setMaxRound(1);

        $vigente = $this->juego->juego_esta_vigente(1);
        $this->assertNotTrue($vigente);
    }
    public function test_juego_esta_vigente_victorias(){
        $vigente = $this->juego->juego_esta_vigente(1);
        $this->assertTrue($vigente);



        $vigente = $this->juego->juego_esta_vigente(4);
        $this->assertNotTrue($vigente);
    }
    protected function preparar_juego()
    {
        $this->juego->agregaArma("piedra");
        $this->juego->agregaArma("papel");
        $this->juego->agregaArma("tijera");
        $this->juego->agregaArma("lagarto");
        $this->juego->agregaArma("spock");

        $this->juego->addRegla("piedra", ["tijera", "lagarto"]);
        $this->juego->addRegla("papel", ["piedra", "spock"]);
        $this->juego->addRegla("tijera", ["lagarto", "papel"]);
        $this->juego->addRegla("lagarto", ["spock", "papel"]);
        $this->juego->addRegla("spock", ["piedra", "tijera"]);
    }
}

