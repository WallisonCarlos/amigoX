<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $correio;
    private $grupos;
    private $notificacoes;
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getSenha() {
        return $this->senha;
    }

    function getCorreio() {
        return $this->correio;
    }

    function getGrupos() {
        return $this->grupos;
    }

    function getNotificacoes() {
        return $this->notificacoes;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setCorreio($correio) {
        $this->correio = $correio;
    }

    function setGrupos($grupos) {
        $this->grupos = $grupos;
    }

    function setNotificacoes($notificacoes) {
        $this->notificacoes = $notificacoes;
    }


    
}
