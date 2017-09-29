<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\MyReadFilter;
use League\Csv\Reader;
use League\Csv\Statement;

class Testcsv extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'converters:testcsv';

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
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$Json = [];
		$catalog = [];
		   $csv = Reader::createFromPath(base_path('assets/c_RegimenFiscal.csv'));
		   //Switch Case
		   	$stmnt = (new Statement())->offset(0)->limit(1);
			$records = $stmnt->process($csv)->getRecords();

			foreach ($records as $offset => $record) {
			$catalog [] =[
				'title' => $record[0],
				];
				dump($catalog);
				'title' == "Catálogo de régimen fiscal." ? $especial = 5 : $especial = 4;

			
			dd($especial);
		}
			//Validity_start
		//    	$stmt_1 = (new Statement())->offset(2)->limit(1);
		// 	$records = $stmt_1->process($csv)->getRecords();

		// 	foreach ($records as $offset => $record) {
		// 	$catalog [] =[
		// 		'Validity_start' => $record[0],
		// 		'Version' => $record[2],
		// 		'Revision' => $record[3]
		// 	];
		// }
		// 	dd($catalog);

			//Catalog Items
		   	// $csv->setHeaderOffset(4);
		   	// $stmt = (new Statement())->offset(4)->limit(3);
		// 	$records = $stmt->process($csv)->getRecords();

		// 	$catalog = [];
		// 	foreach ($records as $offset => $record) {
		// 			// dd($record);
		// 			$properties = collect($record);
		// 			$features = $properties->splice(2);
		// 			// dd($properties, $properties);

		// 		$catalog[] = [
		// 			'code' => $properties->first(),
		// 			'description' => $properties->get('Descripcion'),
		// 			'features' => $features->all()
		// 		];
		// 	 }
		// 		dd($catalog);


		}

}
