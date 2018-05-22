<?php

namespace apps\cms\models;

/**
 * @Entity @Table(name="Noticia")
 **/
class Noticia
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $Codigo;
    
    /** @Column(length=255) **/
    protected $Titulo;
    
    /** @Column(type="integer") **/
    protected $UsuarioAutor;
    
    /** @Column(type="datetime") */
    protected $DataCriacao;
	
	/** @Column(type="datetime", nullable=true) */
    protected $DataPublicacao;
	
	/** @Column(type="datetime", nullable=true) */
    protected $DataAtualizacao;
	
	/** @Column (length=255) */
    protected $Resumo;
	
	/** @Column **/
    protected $Texto;
    
    public function getCodigo()
    {
        return $this->Codigo;
    }
    
    public function setTitulo($titulo)
    {
        $this->Titulo = $titulo;
		return $this;
    }
    
    public function getTitulo()
    {
        return $this->Titulo;
    }
    
    public function setUsuarioAutor($usuarioAutor)
    {
        $this->UsuarioAutor = $usuarioAutor;
		return $this;
    }
    
    public function getUsuarioAutor()
    {
        return $this->UsuarioAutor;
    }
    
    public function setDataCriacao($dataCriacao)
    {
        $this->DataCriacao = $dataCriacao;
		return $this;
    }
    
    public function getDataCriacao()
    {
        return $this->DataCriacao;
    }
	
	public function setDataPublicacao($dataPublicacao)
    {
        $this->DataPublicacao = $dataPublicacao;
		return $this;
    }
    
    public function getDataPublicacao()
    {
        return $this->DataPublicacao;
    }
	
	public function setDataAtualizacao($dataAtualizacao)
    {
        $this->DataAtualizacao = $dataAtualizacao;
		return $this;
    }
    
    public function getDataAtualizacao()
    {
        return $this->DataAtualizacao;
    }
	
	public function setResumo($resumo)
    {
        $this->Resumo = $resumo;
		return $this;
    }
    
    public function getResumo()
    {
        return $this->Resumo;
    }
	
	public function setTexto($texto)
    {
        $this->Texto = $texto;
		return $this;
    }
    
    public function getTexto()
    {
        return $this->Texto;
    }
}