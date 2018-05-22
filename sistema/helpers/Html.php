<?php

namespace sistema\helpers;

use sistema\App;

/* Autor: William Fabrício Werling
 * Data: 20/08/2013
 * Descrição: Classe para criação de controles HTML de forma rápida.
 */

class Html 
{
    private static function montarPropriedades($arrayPropriedades)
    {
        $propriedades = '';
        
        foreach($arrayPropriedades as $prop => $valor)
        {
            //há propriedades onde não há tipo de valor (EX: checked)
            if(empty($prop))
                $propriedades .= $valor;
            else
                $propriedades .= $prop.'="'.$valor.'" ';
        }
        
        return $propriedades;
    }
    
    public static function select($propriedades, $opcoes = null, $metodoGetKey = null, $metodoGetValue = null,  $valorSelecionado = null, $valorBranco = false)
    {
        $select = '<select ';
        $select .= Html::montarPropriedades($propriedades);
        $select .= '>';
        
        if(!is_null($opcoes))
        {
            $options = '';
            $selected = '';
            
            if($valorBranco)
                $options .= '<option value="">Selecione uma opção</option>';

            if(!is_null($metodoGetKey) && !is_null($metodoGetValue))
            {
                foreach($opcoes as $opcao)
                {
                    $selected = '';
                    if(!is_null($valorSelecionado))
                    {
                        if($valorSelecionado == $opcao->$metodoGetKey())
                            $selected = 'selected';
                    }

                    $options .= '<option '.$selected.' value="'.$opcao->$metodoGetKey().'">'.$opcao->$metodoGetValue().'</option>';
                }
            }
            else
            {
                foreach($opcoes as $key => $value)
                {
                    $selected = '';
                    if(!is_null($valorSelecionado))
                    {
                        if($valorSelecionado == $key)
                            $selected = 'selected';
                    }

                    $options .= '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
                }
            }

            $select .= $options;
        }
        
        $select .= '</select>';
        
        return $select;
    }

	public static function radioButtonList($nome, $opcoes = null, $metodoGetKey = null, $metodoGetValue = null,  $valorSelecionado = null, $valorBranco = false)
	{
		$radios = '';
		
		if(!is_null($opcoes))
        {
        	if(!is_null($metodoGetKey) && !is_null($metodoGetValue))
            {
                foreach($opcoes as $opcao)
                {
                    $checked = '';
                    if(!is_null($valorSelecionado))
                    {
                        if($valorSelecionado == $opcao->$metodoGetKey())
                            $checked = 'checked';
                    }

					$radios .= '<input type="radio" '.$checked.' name="'.$nome.'" value="'.$opcao->$metodoGetKey().'">'.$opcao->$metodoGetValue().'<br>';
                }
            }
            else
            {
                foreach($opcoes as $key => $value)
                {
                    $selected = '';
                    if(!is_null($valorSelecionado))
                    {
                        if($valorSelecionado == $key)
                            $selected = 'selected';
                    }

                    $radios .= '<input type="radio" '.$selected.' name="'.$nome.'" value="'.$key.'">'.$value.'<br>';
                }
            }
		}

		return $radios;	
	}   
	 
    public static function link($url, $texto = null, $target = null, $class = null, $id = null, $data = null)
    {
        $link = '<a href="' . $url . '" ';
        
        if(isset($target))
            $link .= 'target="' . $target . '"';
        
        if(isset($class))            
            $link .= 'class="' . $class . '"';

		if(isset($id))            
            $link .= ' id="' . $id . '"';
        
		if(isset($data))
			$link .= ' data-value="' . $data . '"';
        
        $link .= '>';
        
        if(isset($texto))
            $link .= $texto;
                    
        $link .= '</a>';
        
        return $link;
    }
	
	public static function imageLink($imagem, $link, $target = null, $alt = null, $title = null, $class = null, $id = null, $data = null)
    {
    	$link = '<a ';
        
        if(!is_null($class))
            $link .= 'class="' . $class . '" ';
		
		if(isset($target))
            $link .= 'target="' . $target . '"';
		
		if(isset($id))
            $link .= ' id="' . $id . '"';
		
		if(isset($data))
			$link .= ' data-value="' . $data . '"';
		
        $link .= ' >';
        
        $tagImage = '<img src="' . BASE_URL . App::getApp()->getDiretorioImagens() . $imagem . '" alt="' . $alt . '" title="' . $title . '" />';
        
        $link .= $tagImage;
        
        $link .= "</a>";
        
        return $link;
    }
    
    public static function actionlink($texto, $controller = null, $action = null, $parametros = null, $class = null, $id = null, $data = null)
    {
    	$aplicativo = App::getApp()->getPadrao() ? '' : App::getApp()->getNome() . '/'; 
		
    	$link = '<a ';
        
        if(!is_null($class))
            $link .= 'class="' . $class . '" ';
		
		if(!is_null($id))
            $link .= 'id="' . $id . '" ';
		
		if(isset($data))
			$link .= ' data-value="' . $data . '" ';
        	
		if(is_null($controller))
			$link .= 'href="' . BASE_URL . $aplicativo . '" >';
		else if(!is_null($controller) && is_null($action))
            $link .= 'href="' . BASE_URL . $aplicativo . $controller . '" >';
        else if (!is_null($controller) && !is_null($action) && is_null($parametros))
            $link .= 'href="' . BASE_URL . $aplicativo . $controller . '/' . $action . '" >';
        else if (!is_null($controller) && !is_null($action) && !is_null($parametros))
        {
            $link .= 'href="' . BASE_URL . $aplicativo . $controller . '/' . $action . '/';
            
            foreach($parametros as $param)
            {
                $link .= $param . '/';
            }
            
            $link .= '" >';
        }
        
        $link .= $texto;
        $link .= "</a>";
        
        return $link;
    }
    
    public static function actionImage($imagem, $controller = null, $action = null, $parametros = null, $alt = null, $title = null, $class = null, $id = null, $data = null)
    {
    	/* variavél utilizada como complemento do controller caso o aplicativo não seja o padrão,
		 * desta forma, o desenvolvedor não precisa informar o nome do aplicativo toda vez que usar o Redirector
		 */
		$aplicativo = App::getApp()->getPadrao() ? '' : App::getApp()->getNome() . '/';
			
    	$link = '<a ';
        
        if(!is_null($class))
            $link .= 'class="' . $class . '" ';
		
		if(!is_null($id))
            $link .= ' id="' . $id . '" ';
		
		if(isset($data))
			$link .= ' data-value="' . $data . '" ';
        	
		if(is_null($controller))
			$link .= 'href="' . BASE_URL . $aplicativo .'" >';
		else if(!is_null($controller) && is_null($action))
            $link .= 'href="' . BASE_URL . $aplicativo . $controller . '" >';
        else if (!is_null($controller) && !is_null($action) && is_null($parametros))
            $link .= 'href="' . BASE_URL . $aplicativo . $controller . '/' . $action . '" >';
        else if (!is_null($controller) && !is_null($action) && !is_null($parametros))
        {
            $link .= 'href="' . BASE_URL . $aplicativo . $controller . '/' . $action . '/';
            
            foreach($parametros as $param)
            {
                $link .= $param . '/';
            }
            
            $link .= '" >';
        }
        
        $tagImage = '<img ';
		
		if(isset($alt))
			$tagImage .= 'alt="' . $alt . '" ';
		
		if(isset($title))
			$tagImage .= 'title="' . $title . '" ';
		
		$tagImage .= 'src="'. BASE_URL . App::getApp()->getDiretorioImagens() . $imagem . '" />';
        
        $link .= $tagImage;
		
        $link .= "</a>";
        
        return $link;		
    }
    
    public static function actionImageYT($codigoVideo, $controller = null, $action = null, $parametros = null, $nrThumb = 0, $largura = null, $class = null, $id = null, $data = null)
    {
    	/* variavél utilizada como complemento do controller caso o aplicativo não seja o padrão,
		 * desta forma, o desenvolvedor não precisa informar o nome do aplicativo toda vez que usar o Redirector
		 */
		$aplicativo = App::getApp()->getPadrao() ? '' : App::getApp()->getNome() . '/';
		
        $link = '<a ';
        
        if(!is_null($class))
            $link .= 'class="' . $class . '" ';
		
		if(!is_null($id))
            $link .= ' id="' . $id . '" ';
		
		if(isset($data))
			$link .= ' data-value="' . $data . '" ';
        	
		if(is_null($controller))
			$link .= 'href="' . BASE_URL . $aplicativo . '" >';
		else if(!is_null($controller) && is_null($action))
            $link .= 'href="' . BASE_URL . $aplicativo . $controller . '" >';
        else if (!is_null($controller) && !is_null($action) && is_null($parametros))
            $link .= 'href="' . BASE_URL . $aplicativo . $controller . '/' . $action . '" >';
        else if (!is_null($controller) && !is_null($action) && !is_null($parametros))
        {
            $link .= 'href="' . BASE_URL . $aplicativo . $controller . '/' . $action . '/';
            
            foreach($parametros as $param)
            {
                $link .= $param . '/';
            }
            
            $link .= '" >';
        }
        
        $tagImage = '<img src="'.'http://img.youtube.com/vi/' . $codigoVideo . '/' . $nrThumb . '.jpg" width="' . $largura . '" />';
        $link .= $tagImage;
        $link .= "</a>";
        
        return $link;
    }
    
    public static function image($imagem, $alt = null, $title = null, $class = null)
    {
    	$aplicativo = App::getApp()->getPadrao() ? '' : App::getApp()->getNome() . '/';
		
    	$image = '<img ';
		
		if(isset($alt))
			$image .= 'alt="' . $alt . '" ';
		
		if(isset($title))
			$image .= 'title="' . $title . '" ';
		
		if(isset($class))
			$image .= 'class="' . $class . '" ';
		
		$image .= 'src="' . BASE_URL . 'apps/' . $aplicativo . $imagem . '" />';
		
        return $image;        
    }
}