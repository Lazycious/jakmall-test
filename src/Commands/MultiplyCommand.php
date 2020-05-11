<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class MultiplyCommand extends Command
{

    protected $signature;

    protected $description;

    public function __construct()
    {
        $this->signature = sprintf(
            'multiply {numbers* : The numbers to be Multiplied}'
        );
        $this->description = sprintf(
            'Multiply all given Numbers'
        );
        parent::__construct();
    }

    public function handle(): void
    {
        $number = $this->argument('numbers');
        $opration = implode(sprintf(' %s ','*'),$number);
        $result = $this->calculateData($number);
        $output = sprintf('%s = %s', $opration, $result);
        logCalculation("multiply", $opration, $result, $output);
        $this->comment($output);
    }

    protected function calculateData(array $numbers)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        return $this->calculate($this->calculateData($numbers), $number);
    }

    protected function calculate($number1, $number2)
    {
        return $number1 * $number2;
    }
}