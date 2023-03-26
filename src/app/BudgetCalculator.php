<?php
declare(strict_types=1);

namespace App;

class BudgetCalculator
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

    /**
     * @var float
     */
    private float $maximumVehicleAmount;

    /**
     * @var bool
     */
    public bool $isViable = true;

    /**
     * @param float $budget
     */
    public function __construct(
        private readonly float $budget,
    )
    {
        //$this->budget *=100;
        $this->maximumVehicleAmount = $this->budget - $this->fees['basic'] - $this->fees['storage'];

        if ($this->maximumVehicleAmount <= 0) {
            $this->isViable = false;
            $this->fees['basic'] = $this->fees['storage'] = 0.0;
        } else {
            $this->updateFees();
        }
    }

    /**
     * @return void
     */
    public function updateFees(): void
    {
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
    public function getData(): array
    {
        return array_merge(['maximumVehicleAmount' => round($this->maximumVehicleAmount, 2)], $this->fees);
    }

    /**
     * @return $this
     */
    public function findMaximumVehicleAmount(): self
    {
        do {
            $this->maximumVehicleAmount = $this->maximumVehicleAmount - 0.01;
            $this->updateFees();

        } while (!$this->isCalculated());

        return $this;
    }

    /**
     * @return bool
     */
    public function isCalculated(): bool
    {
        return round($this->maximumVehicleAmount + array_sum($this->fees), 2) === $this->budget;
    }

}