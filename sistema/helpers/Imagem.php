<?php

namespace sistema\helpers;

/* Autor: William Fabrício Werling
 * Data: 20/08/2013
 * Descrição: Classe para criação e redimensionamento de imagens 
 */
 
use Exception;

class Imagem
{
    protected $diretorioBase;
	protected $diretorioImagem;
    protected $largura;
    protected $imagem;

	public function setDiretorioBase($diretorioBase)
    {
        $this->diretorioBase = $diretorioBase;            
    }

    public function setDiretorioImagem($diretorioImagem)
    {
        $this->diretorioImagem = $diretorioImagem;            
    }

    public function setLargura($largura)
    {
        $this->largura = $largura;
    }
    
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }

    public function uploadImagem()
    {
    	try
    	{
    		if(is_array($this->imagem['name']))
			{
				if(sizeof($this->imagem['name']) == 1)
				{
					return $this->processaImagemServidor($this->imagem['name'][0], $this->imagem['tmp_name'][0]);
				}
				else {
					$arrayImagensGeradas = array();
					
					foreach ($this->imagem['name'] as $index => $img) 
					{
						$arrayImagensGeradas[] = $this->processaImagemServidor($this->imagem['name'][$index], $this->imagem['tmp_name'][$index]);	
					}
					
					return $arrayImagensGeradas;	
				}				
			}
			else 
			{				
		    	return $this->processaImagemServidor($this->imagem['name'], $this->imagem['tmp_name']);
	        }
        }
		catch(Exception $ex)
		{
			throw $ex;
		}	
    }
    
	private function processaImagemServidor($name, $tmp_name)
	{
		//separo o nome da imagem por cada "."
		$explodeNome = explode('.', $name);
		
		//recupero a extensão da imagem e transformo em letras minúsculas
		$extensao = strtolower(end($explodeNome));			
        
		//retiro a extensão da imagem do array
		array_pop($explodeNome);
		
		//uno as palavras que foram separadas anteriormente separadas
		$auxNome = implode('.', $explodeNome);
		
		//gero um nome único para a imagem usando o nome dela como prefixo
		$nome = uniqid($auxNome);
        
        $tempImagem = '';
	
		switch ($extensao) {
			case 'jpg':
			case 'jpeg':
				$tempImagem = imagecreatefromjpeg($tmp_name);
				break;
			case 'gif':
				$tempImagem = imagecreatefromgif($tmp_name);	
				break;
			case 'png':			
				$tempImagem = imagecreatefrompng($tmp_name);
            	imageAlphaBlending($tempImagem, true);
            	imageSaveAlpha($tempImagem, true);	
				break;
			default:
				throw new Exception("Formato de imagem inválida!");
				break;
		}
	
        $x = imagesx($tempImagem);
        $y = imagesy($tempImagem);
        $altura = ($this->largura * $y)/$x;

        $imagemRedimensionada = imagecreatetruecolor($this->largura, $altura);
        imagealphablending($imagemRedimensionada, false);
        imageSaveAlpha($imagemRedimensionada, true);
		
        imagecopyresampled($imagemRedimensionada, $tempImagem, 0, 0, 0, 0, $this->largura, $altura, $x, $y);

        $arquivoDisco = $this->diretorioBase . '/' . $this->diretorioImagem . '/';
        $arquivoURL = $this->diretorioImagem . '/';
        
        //verifica se existe o diretório, caso não exista, cria o diretório de imagens
        if(!is_dir($arquivoDisco))
        	mkdir($arquivoDisco);
        
		switch ($extensao) {
			case 'jpg':
			case 'jpeg':
				$arquivoDisco .= $nome . '.jpg';
            	$arquivoURL .= $nome . '.jpg';
            	imagejpeg($imagemRedimensionada, $arquivoDisco);
				break;
			case 'gif':
				$arquivoDisco .= $nome . '.gif';
	            $arquivoURL .= $nome . '.gif';
	            imagegif($imagemRedimensionada, $arquivoDisco);	
				break;
			case 'png':			
				$arquivoDisco .= $nome . '.png';
	            $arquivoURL .= $nome . '.png';
	            imagepng($imagemRedimensionada, $arquivoDisco);	
				break;			
		}
		
		imagedestroy($tempImagem);
        imagedestroy($imagemRedimensionada);	

        return $arquivoURL;
	}
	
    public function removeImagem($imagem)
    {
        if(file_exists($imagem))
            return unlink($imagem);
        else
            return false;
    }
}