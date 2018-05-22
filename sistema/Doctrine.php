<?php

namespace sistema;

/* Autor: William Fabrício Werling
 * Data: 20/08/2013
 * Descrição: Classe que possui instância do Doctrine, ORM responsável por manipular dados no Banco de dados. 
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Sistema\Helpers\XMLManager;

class Doctrine {
    private static $em;
	
	//padrão singleton, onde retorno instãncia de um EntityManager
    public static function em() {
        if(is_null(self::$em)){
            self::$em = self::loadDoctrine();
		}
        
        return self::$em;
    }
	
	private static function loadDoctrine() {
    	$lib = BASE_DIR . 'libs';
        
		$xmlManager = new XMLManager();
		$xmlData = $xmlManager->carregarXML(BASE_DIR . 'configs/doctConfig.xml')->getXML();
		
		$conexao = self::getConexaoDefault($xmlData);
		
        $isDevMode = $conexao['desenvolvimento'];
        
        if ($isDevMode)
            $cache = new \Doctrine\Common\Cache\ArrayCache;
		else
            $cache = new \Doctrine\Common\Cache\ArrayCache;        
		
        $dirModels = array( BASE_DIR . $xmlData->diretorios->models);
        $dirProxies = BASE_DIR . $xmlData->diretorios->proxies;
		
        $config = Setup::createAnnotationMetadataConfiguration($dirModels, $isDevMode, $dirProxies, $cache);

        $conn = null;
		
        // Configuração de acesso ao banco de dados
        $conn = array(
            'driver' => (String)$conexao->driver,
            'user' => (String)$conexao->user,
            'password' => (String)$conexao->password,
            'dbname' => (String)$conexao->dbname,
            'charset' => (String)$conexao->charset
        );            
		
        // Obtendo uma instância do Entity Manager
        return EntityManager::create($conn, $config);
    }

	private static function getConexaoDefault($xmlData) {
		foreach($xmlData as $data) {
			if($data['default'] == true)
				return $data;
		}
	}
}