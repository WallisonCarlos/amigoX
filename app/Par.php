<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Par extends Model
{
    private $id;
    private $de;
    private $para;
    
    function getId() {
        return $this->id;
    }

    function getDe() {
        return $this->de;
    }

    function getPara() {
        return $this->para;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDe($de) {
        $this->de = $de;
    }

    function setPara($para) {
        $this->para = $para;
    }


}
