<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    private $id;
    private $titulo;
    private $membros;
    private $administrador;
    private $amigosSecretos;
    
    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getMembros() {
        return $this->membros;
    }

    function getAdministrador() {
        return $this->administrador;
    }

    function getAmigosSecretos() {
        return $this->amigosSecretos;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setMembros($membros) {
        $this->membros = $membros;
    }

    function setAdministrador($administrador) {
        $this->administrador = $administrador;
    }

    function setAmigosSecretos($amigosSecretos) {
        $this->amigosSecretos = $amigosSecretos;
    }


    
}
