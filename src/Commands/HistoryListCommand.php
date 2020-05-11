<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class HistoryListCommand extends Command
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
        $this->description = 'Show calculation history';
        $this->signature = generateCommandSignature('history:list', [
            [
                'name' => 'commands?*',
                'description' => 'Filter the history by the commands'
            ],
            [
                'name' => '--D|driver=database',
                'description' => 'Driver for storage connection'
            ]
        ], true);

        parent::__construct();
    }

    public function handle(): void
    {
        $filters = $this->argument('commands');
        $data = fetchData(strtolower($this->option('driver')) === 'database');

        if (!empty($filters)) {
            $data = $data->whereInStrict('command', $filters)->values();
        }

        $data->transform(function($datum, $index) {
            return collect($datum)->prepend($index, 'no')->forget('identifier')->toArray();
        });

        if (count($data) === 0) {
            $this->comment('History is empty.');
        } else {
            $j = 0; 
            foreach( $data as $element ) {  
                $data[$j] = array_map('ucfirst',$element); 
                $j++; 
            } 
            $this->table(array_map('ucfirst', array_keys($data->first())), $data->toArray());
        }
    }
}