<?php

namespace App;

class Calculator implements CalculatorMethodInterface
{
    private const BASIC_FEE_MIN = 10.0;
    private const BASIC_FEE_MAX = 50.0;

    /**
     * @var array|float[]
     */
    private array $fees = [
        'basic' => self::BASIC_FEE_MIN,
        'special' => 0.0,
        'storage' => 100.0,
        'association' => 0.0,
    ];

    private float $budget = 0.0;

    private float $maximumVehicleAmount;

    /**
     * @param float $budget
     * @return array
     */
    public function calculate(float $budget): array
    {
        $this->budget = $budget;
        $this->maximumVehicleAmount = $this->budget - $this->fees['basic'] - $this->fees['storage'];

        if ($this->maximumVehicleAmount <= 0) {
            $this->maximumVehicleAmount = $this->fees['basic'] = $this->fees['storage'] = 0.0;

            return $this->getData();
        }

        $this->updateFees();

        return $this->findMaximumVehicleAmount()->getData();
    }

    /**
     * @return $this
     */
    private function findMaximumVehicleAmount(): self
    {
        while ($this->maximumVehicleAmount + array_sum($this->fees) > $this->budget) {
            $this->maximumVehicleAmount = $this->maximumVehicleAmount - 0.01;
            $this->updateFees();
        }

        return $this;
    }

    /**
     * @return void
     */
    private function updateFees(): void
    {
        $this->maximumVehicleAmount = round($this->maximumVehicleAmount, 2);

        $this->fees['special'] = round($this->maximumVehicleAmount * 0.02, 2);
        $this->fees['basic'] = round($this->maximumVehicleAmount * 0.10, 2);

        if ($this->fees['basic'] > self::BASIC_FEE_MAX) {
            $this->fees['basic'] = self::BASIC_FEE_MAX;
        } elseif ($this->fees['basic'] < self::BASIC_FEE_MIN) {
            $this->fees['basic'] = self::BASIC_FEE_MIN;
        }

        $this->fees['association'] = match (true) {
            $this->maximumVehicleAmount >= 1 && $this->maximumVehicleAmount <= 500 => 5.0,
            $this->maximumVehicleAmount > 500 && $this->maximumVehicleAmount <= 1000 => 10.0,
            $this->maximumVehicleAmount > 1000 && $this->maximumVehicleAmount <= 3000 => 15.0,
            $this->maximumVehicleAmount > 3000 => 20.0,
            default => 0.0,
        };
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        return array_merge(['maximumVehicleAmount' => $this->maximumVehicleAmount], $this->fees);
    }
}