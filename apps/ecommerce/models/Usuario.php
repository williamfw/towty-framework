<?php

namespace apps\cms\models;

/**
 * @Entity @Table(name="Usuario")
 **/
class Usuario 
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $Codigo;
    
    /** @Column(length=200) **/
    protected $NomeCompleto;
    
    /** @Column(length=50) **/
    protected $Usuario;
    
    /** @Column(length=32) **/
    protected $Senha;
    
    public function getCodigo()
    {
        return $this->Codigo;
    }
    
    public function setNomeCompleto($nomeCompleto)
    {
        $this->NomeCompleto = $nomeCompleto;
		return $this;
    }
    
    public function getNomeCompleto()
    {
        return $this->NomeCompleto;        
    }
    
    public function setUsuario($usuario)
    {
        $this->Usuario = $usuario;
		return $this;
    }
    
    public function getUsuario()
    {
        return $this->Usuario;        
    }
    
    public function setSenha($senha)
    {
        $this->Senha = $senha;
		return $this;
    }
    
    public function getSenha()
    {
        return $this->Senha;        
    }
}