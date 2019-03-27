<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    private $id;
    private $conteudo;
    private $de;
    private $para;
    private $timestamp;
    
    function getId() {
        return $this->id;
    }

    function getConteudo() {
        return $this->conteudo;
    }

    function getDe() {
        return $this->de;
    }

    function getPara() {
        return $this->para;
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

    function setDe($de) {
        $this->de = $de;
    }

    function setPara($para) {
        $this->para = $para;
    }

    function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }


}
