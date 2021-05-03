<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourtController extends Controller
{
    public function get_court_list(){
        $courts = DB::table('court as c')
            ->leftjoin('medias as m','m.id','=','c.image_id')
            ->select('c.name','c.tagline','m.file_path as image','features','location')->where('c.status',1)->get();
        $courts->map(function ($obj){
            $obj->image = asset($obj->image);
            return $obj;
        });

        $response = [
            'staus' => true,
            'data' => $courts
        ];

        return response($response, 403);
    }
}
