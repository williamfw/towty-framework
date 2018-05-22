<?php

namespace apps\site\dao;

/* Autor: William Fabrício Werling
 * Data: 21/08/2013
 * Descrição: Todo objeto DAO deve herdar essa classe, que contem os métodos genéricos 
 * para persistência de dados no banco 
 */
use apps\cms\doctrine\DoctrineHelper;

abstract class DAOBase 
{
    //atributos
    private $model;
    
    //propriedades
    protected function getModel()
    {
        return $this->model;
    }

    protected function __construct($model) {
        $this->model = $model;
    }
    
    public function Salvar($objeto)
    {
        DoctrineHelper::getEm()->persist($objeto);
        DoctrineHelper::getEm()->flush();
    }
    
    public function Excluir($objeto)
    {
        DoctrineHelper::getEm()->remove($objeto);
        DoctrineHelper::getEm()->flush();
    }
    
    public function Selecionar($codigo)
    {
        $objeto = DoctrineHelper::getEm()->find($this->model, $codigo);
        return $objeto;
    }
    
    public function SelecionarTodos()
    {
        $qb = DoctrineHelper::getEm()->createQueryBuilder();
        $lista = $qb->select('obj')
                     ->from($this->model, 'obj')                      
                     ->getQuery()
                     ->getArrayResult();
        return $lista;
    }
    
    public function SelecionarPrimeiroRegistro()
    {
        $qb = DoctrineHelper::getEm()->createQueryBuilder();
        $objeto = $qb->select('obj')
                      ->from($this->model, 'obj')                      
                      ->setMaxResults(1)
                      ->getQuery()
                      ->getResult();
        return $objeto;
    }
}