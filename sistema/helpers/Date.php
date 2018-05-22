<?php

namespace sistema\helpers;

use DateTime;

/* Autor: William Fabrício Werling
 * Data: 29/08/2013
 * Descrição: Classe com métodos que facilitam o trabalho com DateTime 
 */

class Date
{
	//Converte uma string com data no padrão brasileiro para DateTime
    public static function toDateTime($string)     
    {
        try
        {
            $dataEHora = explode(' ', $string);
            $data = explode('/', $dataEHora[0]);

            $novaData = new DateTime();
            $novaData->setDate($data[2], $data[1], $data[0]);
			
			if(sizeof($dataEHora) > 1)
			{
            	$hora = explode(':', $dataEHora[1]);
            	$novaData->setTime($hora[0], $hora[1], 0);
			}
			else 
			{
				$novaData->setTime(0, 0, 0);				
			}

            return $novaData;
        }
        catch(Exception $e)
        {
            throw new Exception('Data com formato inválido');
        }
    }
	
	//Converte um DateTime para String no padrão Brasileiro(aa/mm/aaaa)
	public static function toString($dateTime)
	{	
		return $dateTime->format('d/m/Y H:i:s');
	}
}