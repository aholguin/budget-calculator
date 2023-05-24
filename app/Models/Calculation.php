<?php

namespace App\Models;

use App\Model;

class Calculation extends Model
{
    public function findAll(): array
    {
        $query = "SELECT budget,vehicle_amount as maximumVehicleAmount,basic,special,association,storage 
                    FROM calculations
                    ORDER BY  id desc";

        $stmt = $this->db->query($query);

        return $stmt->fetchAll();
    }

    public function findByBudget(float $budget): bool
    {
        $sth = $this->db->query('SELECT * FROM calculations WHERE budget = ' . $budget);

        return $sth->rowCount();
    }

    public function create(
        float $budget,
        float $maximumVehicleAmount,
        float $basic,
        float $special,
        float $association,
        float $storage
    ): int
    {
        $query = "INSERT INTO calculations (budget,vehicle_amount,basic,special,association,storage)
                        VALUES (:budget,:vehicle_amount,:basic,:special,:association,:storage);";

        $sth = $this->db->prepare($query);

        $sth->bindValue(':budget', $budget);
        $sth->bindValue(':vehicle_amount', $maximumVehicleAmount);
        $sth->bindValue(':basic', $basic);
        $sth->bindValue(':special', $special);
        $sth->bindValue(':association', $association);
        $sth->bindValue(':storage', $storage);

        $sth->execute();

        return $this->db->lastInsertId();
    }
}