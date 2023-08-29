<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert; // Importo 'Assert' del componente validator/constraint para poder hacer validaciones.

class GameFormUpload
{
    //Atributos
    #[Assert\NotBlank(message: 'El campo Nombre es obligatorio.')]
    protected $name;

    #[Assert\File( // Le agrego validaciones a la subida de imagenes.
        maxSize: "10M", // Restriccion de tamaño: Que no tenga más de 10mb
        mimeTypes: // Restricción de mimetypes: Que solo sea jpeg, jpg o png
        [
            "image/jpeg",
            "image/jpg",
            "image/png"
        ],
        mimeTypesMessage: 'La imagen debe ser JPEG, JPG o PNG.',
        maxSizeMessage: 'La imagen no puede pesar más de 10mb.',
    )]
    protected $image;

    #[Assert\NotBlank(message: 'El campo Descripción es obligatorio.'),
    Assert\Length(
        max: 255,
        maxMessage: 'Se sobrepasó el máximo de 255 caracteres permitidos en la descripción.'
    )]
    protected $description;

    #[Assert\Positive(message: 'Se debe seleccionar una Plataforma.')]
    protected $platform;

    #[Assert\Positive(message: 'Se debe seleccionar un Género.')]
    protected $gender;

    #[Assert\NotBlank(message: 'El campo Sitio web es obligatorio.'),
    Assert\Length(
        max: 80,
        maxMessage: 'Se sobrepasó el máximo de 80 caracteres permitidos en la url.'
    ),
    Assert\Url(message: 'La url {{ value }} no es válida.'
    )]
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
