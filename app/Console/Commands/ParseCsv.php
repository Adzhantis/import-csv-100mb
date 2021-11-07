<?php

namespace App\Console\Commands;

use App\Models\DescendingYearOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use SplFileObject;

class ParseCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->parse();
       // $this->parseBySpl();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }

    private function csvRead($filename, $delimeter=',')
    {
        $header = [];
        $row = 0;
        # tip: dont do that every time calling csv_read(), pass handle as param instead ;)
        $handle = fopen($filename, "r");

        if ($handle === false) {
            return false;
        }

        while (($data = fgetcsv($handle, 0, $delimeter)) !== false) {

            if (0 == $row) {
                $header = $data;
            } else {
                # on demand usage
                yield array_combine($header, $data);
            }

            $row++;
        }
        fclose($handle);
    }

    private function parse()
    {
        DescendingYearOrder::truncate();
        $generator = $this->csvRead(__DIR__ . '/Data7602DescendingYearOrder.csv');

        foreach ($generator as $index => $item) {
            $chunk[] = $item;
            if ($index % 1000 === 0) {
                DescendingYearOrder::insert($chunk);
                unset($chunk);
                echo memory_get_usage() . "\n";
            }
        }
    }
}
