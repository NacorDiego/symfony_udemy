<?php

namespace App\Entity;

class Persona
{
    //Atributos
    protected $nombre;
    protected $correo;
    protected $telefono;

    //Métodos
    public function getNombre():string
    {
        return $this->nombre;
    }
    public function setNombre(string $nombre):void
    {
        $this->nombre = $nombre;
    }
    public function getCorreo():string
    {
        return $this->correo;
    }
    public function setCorreo(string $correo):void
    {
        $this->correo = $correo;
    }
    public function getTelefono():string
    {
        return $this->telefono;
    }
    public function setTelefono(string $telefono):void
    {
        $this->telefono;
    }
}