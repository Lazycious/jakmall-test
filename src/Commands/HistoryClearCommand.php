<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class HistoryClearCommand extends Command
{
    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $signature;

    public function __construct()
    {
        $this->description = "Clear saved history";
        $this->signature = generateCommandSignature('history:clear', [], true);

        parent::__construct();
    }

    public function handle(): void
    {
        writeData(null);
        $this->comment('History cleared!');
    }
}