<?php

namespace Models;


use Uniqoders\Game\Models\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{

   protected $player;
    protected function setUp(): void
    {
        $this->juego = new Player();

    }


    public function testGetArma()
    {
        $this->juego->setArma("papel");
        $this->assertEquals("papel",$this->juego->getArma());
    }

    public function testGetEmpates()
    {
        $this->juego->aumenta_empates();
        $this->assertEquals(1,$this->juego->getEmpates());
    }

    public function testGetNombre()
    {
        $this->juego->setNombre("Abraham");
        $this->assertEquals("Abraham",$this->juego->getNombre());
    }

    public function testGetVictorias()
    {
        $this->juego->aumenta_victorias();
        $this->juego->aumenta_victorias();
        $this->assertEquals(2,$this->juego->getVictorias());
    }

    public function testGetDerrotas()
    {
        $this->juego->aumenta_derrotas();
        $this->juego->aumenta_derrotas();
        $this->juego->aumenta_derrotas();
        $this->assertEquals(3,$this->juego->getDerrotas());
    }
}
