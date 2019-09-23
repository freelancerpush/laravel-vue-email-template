<?php
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$badWords=["How", "When", "Hi", "Hello", "Where", "stupid"];
    	foreach ($badWords as $key => $value) {
    	
	        DB::table('spams')->insert([
	            'badwords' => $value,
	        ]);
    	}
    }
}
