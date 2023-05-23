<?php
declare(strict_types=1);

namespace App;

class IndexController
{
    public function show(): void
    {

        $pdo = App::db();

        $query = "SELECT budget,vehicle_amount as maximumVehicleAmount,basic,special,association,storage 
                    FROM calculations 
                    ORDER BY  id desc";

        $stmt = $pdo->query($query);

        echo View::make('index', $stmt->fetchAll());
    }

    public function calculate(): void
    {
        if (isset($_POST['budget'])) {
            $budget = (float)$_POST['budget'];
            $calculator = new Calculator();
            $budgetCalculator = new  BudgetCalculator($budget, $calculator);

            $calculations = $budgetCalculator->getCalculateData();

            $pdo = App::db();

            $sth = $pdo->query('SELECT * FROM calculations WHERE budget = ' . $budget);

            if ($sth->rowCount() === 0) {
                $query = "INSERT INTO calculations (budget,vehicle_amount,basic,special,association,storage)
                        VALUES (:budget,:vehicle_amount,:basic,:special,:association,:storage);";

                $sth = $pdo->prepare($query);
                $sth->bindValue(':budget', $budget);
                $sth->bindValue(':vehicle_amount', $calculations['maximumVehicleAmount']);
                $sth->bindValue(':basic', $calculations['basic']);
                $sth->bindValue(':special', $calculations['special']);
                $sth->bindValue(':association', $calculations['association']);
                $sth->bindValue(':association', $calculations['association']);
                $sth->bindValue(':storage', $calculations['storage']);

                $sth->execute();
            }
        }

        $this->show();
    }
}