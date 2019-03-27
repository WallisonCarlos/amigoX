<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversa extends Model
{
    private $id;
    private $usuario;
    private $amigo;
    private $mensagens;
    private $timestamp;
    
    function getId() {
        return $this->id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getAmigo() {
        return $this->amigo;
    }

    function getMensagens() {
        return $this->mensagens;
    }

    function getTimestamp() {
        return $this->timestamp;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setAmigo($amigo) {
        $this->amigo = $amigo;
    }

    function setMensagens($mensagens) {
        $this->mensagens = $mensagens;
    }

    function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

}
