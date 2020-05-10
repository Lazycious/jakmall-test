<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class PowCommand extends Command
{

    protected $signature;

    protected $description;

    public function __construct()
    {
        $this->signature = 'pow
        {base : The base number}
        {exp : The exponent number}';
        $this->description = sprintf(
            'Exponent the given number'
        );
        parent::__construct();
    }

    public function handle(): void
    {
        $number = $this->argument('base');
        $exp = $this->argument('exp');
        $opration = $number.' ^ '.$exp;
        $result = pow($number,$exp);
        $this->comment(
            sprintf(
                '%s = %s', $opration, $result
            )
        );
    }
}