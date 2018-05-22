<?php

namespace sistema\helpers;

/* Autor: William Fabrício Werling
 * Data: 20/08/2013
 * Descrição: Classe para manipulação de Sessions no sistema. 
 */

class Session
{
    public function criarSession($nome, $valor, $serialize = false)
    {
        $_SESSION[$nome] = $serialize ? serialize($valor) : $valor;
        return $this;
    }
    
    public function setSession($nome, $valor, $serialize = false)
    {
        $this->criarSession($nome, $valor, $serialize);
        return $this;
    }

    public function selecionarSession($nome, $unserialize = false)
    {
        return isset($_SESSION[$nome]) ? ($unserialize ? unserialize($_SESSION[$nome]) : $_SESSION[$nome])  : null;
    }

    public function excluirSession($nome)
    {
        unset($_SESSION[$nome]);
        return $this;
    }       

    public function checarSession($nome)
    {
        return isset($_SESSION[$nome]);
    }
}