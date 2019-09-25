<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;
use App\Spam;

class EmailTepmlateController extends Controller {
	public function storeItem(Request $request) {
		$data = new Template ();
		$data->name = $request->name;
		$data->subject = $request->subject;
		$data->description = $request->description;
		$data->save();
		return $data;
	}
	public function readItems() {
		$data = Template::all ();
		return $data;
	}
	public function readSpamItems() {
		$data = Spam::pluck('badwords');
		return $data;
	}
	public function deleteItem(Request $request) {
		$data = Template::find ( $request->id )->delete ();
	}
	public function editItem(Request $request, $id){
		$data =Template::where('id', $id)->first();
		$data->name = $request->get('val1');
		$data->subject = $request->get('val2');
		$data->description = $request->get('val3');
		$data->save();
		return $data;
	}
}