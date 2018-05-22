<?php

namespace apps\cms\doctrine;

/* Autor: William Fabrício Werling
 * Data: 20/08/2013
 * Descrição: Classe que possui instância do Doctrine, ORM responsável por manipular dados no Banco de dados. 
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DoctrineHelper
{
    private static $em;
	
    public static function getEm()
    {
        if(is_null(self::$em))
            self::$em = self::inicializaDoctrine();
        
        return self::$em;
    }
	
	private static function inicializaDoctrine()
    {
    	$lib = ROOT . '/libs';
        Setup::registerAutoloadDirectory($lib);
        
        $applicationMode = 'desenvolvimento';
        //$applicationMode = 'produção';
        $isDevMode = true;
        
        if ($applicationMode == 'desenvolvimento') 
        {
            $isDevMode = true;
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        } 
        else 
        {
            $isDevMode = false;
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        }
        
        $paths = array( ROOT . 'apps/cms/models/' );
        $proxies = ROOT . '/apps/cms/proxies/';
		
        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $proxies, $cache);

        $conn = null;
        
        // Configuração de acesso ao banco de dados
        if($isDevMode)
        {
            $conn = array(
                'driver' => 'pdo_mysql',
                'user' => 'root',
                'password' => '',
                'dbname' => 'geckoscms',
                'charset' => 'utf8'
            );            
        }
        else
        {
            $conn = array(
                'driver' => 'pdo_mysql',
                'host' => 'mysql.towty.com.br',
                'user' => 'towty',
                'password' => 'qwetowty1324',
                'dbname' => 'towty',
                'charset' => 'utf8'
            );    
        }

        // Obtendo uma instância do Entity Manager
        return EntityManager::create($conn, $config);
    }
}