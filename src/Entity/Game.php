<?php

namespace App\Entity;

class Game
{
    //Atributos
    protected $name;
    protected $image;
    protected $description;
    protected $platform;
    protected $gender;
    protected $url;

    //Métodos
    public function getName():string
    {
        return $this->name;
    }
    public function setName(string $name):void
    {
        $this->name = $name;
    }

    public function getImage():string
    {
        return $this->image;
    }
    public function setImage(string $image):void
    {
        $this->image = $image;
    }

    public function getDescription():string
    {
        return $this->description;
    }
    public function setDescription(string $description):void
    {
        $this->description = $description;
    }

    public function getPlatform():string
    {
        return $this->platform;
    }
    public function setPlatform(string $platform):void
    {
        $this->platform = $platform;
    }

    public function getGender():string
    {
        return $this->gender;
    }
    public function setGender(string $gender):void
    {
        $this->gender = $gender;
    }

    public function getUrl():string
    {
        return $this->url;
    }
    public function setUrl(string $url):void
    {
        $this->url = $url;
    }
}