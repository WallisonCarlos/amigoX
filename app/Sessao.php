<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sessao extends Model
{
    private $id;
    private $titulo;
    private $participantes;
    private $pares;
    private $timestamp;
    
    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getParticipantes() {
        return $this->participantes;
    }

    function getPares() {
        return $this->pares;
    }

    function getTimestamp() {
        return $this->timestamp;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setParticipantes($participantes) {
        $this->participantes = $participantes;
    }

    function setPares($pares) {
        $this->pares = $pares;
    }

    function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }


}
