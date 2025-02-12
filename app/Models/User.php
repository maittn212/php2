<?php

namespace App\Models;
use App\Model;

class User extends Model{
    protected $tableName = "users";
    public function checkExistsEmailForCreate($email){
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('COUNT(*)')
            ->from($this->tableName)
            ->where('email = :email')
            ->setParameter('email',$email);
        $result = $queryBuilder->fetchOne();
        // Nếu số lượng >0 là email đã tồn tại
        return $result > 0;
    }

    public function checkExistsEmailForUpdate($id, $email){
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('COUNT(*)')
            ->from($this->tableName)
            ->where('email = :email')
            ->andWhere('id != :id')
            ->setParameter('email',$email);
        $result = $queryBuilder->fetchOne();
        // Nếu số lượng >0 là email đã tồn tại
        return $result > 0;
    }
}