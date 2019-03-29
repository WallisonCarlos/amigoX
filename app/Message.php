<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    private $id;
    private $conteudo;
    private $autor;
    private $timestamp;
    
    function getId() {
        return $this->id;
    }

    function getConteudo() {
        return $this->conteudo;
    }

    function getAutor() {
        return $this->autor;
    }

    function getTimestamp() {
        return $this->timestamp;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setConteudo($conteudo) {
        $this->conteudo = $conteudo;
    }

    function setAutor($autor) {
        $this->autor = $autor;
    }

    function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
    
}
