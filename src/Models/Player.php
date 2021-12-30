<?php

namespace Uniqoders\Game\Models ;

class Player
{
    protected int $victorias=0;
    protected int $derrotas=0;
    protected ?int $empates= 0;
    protected string $arma="";
    protected $nombre;


    public function __construct()
    {
        $this->victorias = 0;
        $this->derrotas = 0;
        $this->empates = 0;
        $this->arma="";
    }

    /**
     * @return int
     */
    public function getVictorias()
    {
        return $this->victorias;
    }

    /**
     * @return int
     */
    public function getDerrotas()
    {
        return $this->derrotas;
    }

    /**
     * @return int
     */
    public function getEmpates()
    {
        return $this->empates;
    }

    /**
     * @return string
     */
    public function getArma()
    {
        return $this->arma;
    }

    /**
     * @param string $arma
     */
    public function setArma($arma)
    {
        $this->arma = $arma;
    }



    public function aumenta_victorias(){
        $this->victorias++;
    }
    public function aumenta_derrotas(){
        $this->derrotas++;
    }
    public function aumenta_empates(){
        $this->empates++;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }
}