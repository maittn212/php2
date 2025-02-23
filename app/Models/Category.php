<?php
namespace App\Models;
use App\Model;
class Category extends Model{
    protected $tableName = 'categories';
    public function getCategoryOnlyActive(){
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder ->select('*')
            ->from($this->tableName)
            ->where('is_active = 1');
        return $queryBuilder->fetchAllAssociative();
    }
    public function checkExistNameForCreate($name){
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('COUNT(*)')
            ->from($this->tableName)
            ->where('name = :name')
            ->setParameter('name', $name);
        $result = $queryBuilder->fetchOne();
        return $result >0;
    }
    public function checkExistNameForUpdate($id, $name){
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('COUNT(*)')
            ->from($this->tableName)
            ->where('name = :name')
            ->andWhere('id != :id')
            ->setParameter('id', $id)
            ->setParameter('name', $name);
        $result = $queryBuilder->fetchOne();
        return $result >0;
    }
}