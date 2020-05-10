<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class AddCommand extends Command
{

    protected $signature;

    protected $description;

    public function __construct()
    {
        $this->signature = sprintf(
            'add {numbers* : The numbers to be added}'
        );
        $this->description = sprintf(
            'Add all given Numbers'
        );
        parent::__construct();
    }

    public function handle(): void
    {
        $number = $this->argument('numbers');
        $opration = implode(sprintf(' %s ','+'),$number);
        $result = $this->calculateData($number);
        $this->comment(
            sprintf(
                '%s = %s', $opration, $result
            )
        );
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
        return $number1 + $number2;
    }
}