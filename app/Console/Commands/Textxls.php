<?php

namespace App\Console\Commands;

use App\Helpers\CodeValueBinder;
use Illuminate\Console\Command;

class Textxls extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'converters:testxls';

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
		$json = []; 
		$features = [];
		// $CodeValueBinder = new CodeValueBinder;

		// \Excel::load(base_path('assets/catCFDI_.xls'), function(){})->get()
		\Excel::load(base_path('assets/catCFDI_.xls'), function($reader) use (&$json, &$features){	
			// dd(get_class($reader->get()));
			// dd($reader);
			$reader->get()->only(0)->each(function($sheet, $key) use (&$json, &$features){
				$title = $sheet->getTitle();

				$json = $this->catalog_title_assignment($json, $title);

					dd($key);
				$sheet->each(function($row, $key) use ($title, &$json,&$features){
					if($key == 2){
						$json = $this->catalog_metadata_assignment($json, $title, $row);
					}
					if($key == 5){
						// dd($row);
						$features = array_where($row->all(), function ($heading, $key){
							return !is_null($heading) && $key >=2;
						});
						// dd($features);
					}

					$start_line = $this->get_catalog_start_line($title);

					if($key >= $start_line){
						$json = $this->catalog_item_details($json, $title, $row, $features);
					}
				dd('running!!');

				});
			});
					// dd($json);
		});
	}

	public function catalog_title_assignment($json, $title)
	{
		$json[$title] = [
			'type' => $title,
			'validity_start' => null,
			'version' => null,
			'revision' => null,
			'catalog' => null,
		]; 
		return $json;
	}

	public function catalog_metadata_assignment($json, $title, $row)
	{
		$json[$title]['validity_start'] = $row[0]->toDateString();  
		$json[$title]['version'] = $row[2];  
		$json[$title]['revision'] = $row[3]; 

		return $json;
	}

	public function get_catalog_start_line($title)
	{
		switch ($title){
			case "c_RegimenFiscal":
				return 6;
			break;
			default: 
				return 5;
		}
	}

	public function catalog_item_details($json, $title, $row, $features)
	{
		// dump($features);
		$features = collect($features)->mapWithKeys(function($feature, $key) use ($row){
			return [$feature => $row[$key]];			
		});
		$json[$title]['catalog'][] = [
			// 'code' => $this->format_code_by_code_type($row[0]),
			'code' => $row[0],
			'descrption' => $row[1],
			'features' => $features->all(),
		];
		// $string = $json[$title]['catalog'];
		// dd($string);
		return $json;
	}

	// public function for($code)
	// {
	// 	is_string($code);
	// 	is_float($code);
	// 	is_integer($code);
	// 	return $new_code;
	// }
}
