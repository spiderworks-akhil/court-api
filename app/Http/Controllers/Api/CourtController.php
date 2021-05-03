<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Day;
use App\Models\Holiday;
use App\Models\Slots;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourtController extends Controller
{
    public function get_court_list(){
        $courts = DB::table('court as c')
            ->leftjoin('medias as m','m.id','=','c.image_id')
            ->select('c.name','c.tagline','m.file_path as image','features','longitude','latitude','timings','restrictions','facilities','c.location as phone')
            ->where('c.status',1)->get();
        $courts->map(function ($obj){
            $obj->image = asset($obj->image);
            $obj->restrictions = explode(',',$obj->restrictions);
            $obj->facilities = explode(',',$obj->facilities);
            return $obj;
        });

        $response = [
            'staus' => true,
            'data' => $courts
        ];

        return response($response, 200);
    }

    public function get_court_slots(Request $request){
        $date = $request->date;
        $court_id = $request->court_id;
        $court = Court::select('name')->find($court_id);
        if(!$court){
            $response = [
                'staus' => false,
                'message' => 'Court not found',
            ];
            return response($response, 200);
        }
        $d = Carbon::parse($date)->format('l');
        $day = Day::where('name',$d)->first();
        $holiday = Holiday::where('date',$date)->first();

        if($holiday){
            $surcharge = $holiday->surcharge;
        }else{$surcharge =0;}

        $slots = Slots::select('slot_number','price','is_slot_open','status')->where('day_id',$day->id)->where('court_id',$court_id)->orderby('slot_number','ASC')->get();

        if(count($slots) == 0){
            $response = [
                'staus' => false,
                'message' => 'No slots added, Please contact directly'
            ];
            return response($response, 200);
        }

        $f = Carbon::parse('00:00:00 1-1-2020');
        $t = Carbon::parse('00:30:00 1-1-2020');

        $slots->map(function ($item)use($surcharge,$f,$t){
            $item->price = $item->price+$surcharge;
            $item->slot_time = $f->addMinutes(30)->format('H:i').' - '.$t->addMinutes(30)->format('H:i');
            return $item;
        });

        $response = [
            'staus' => true,
            'day' => $d,
            'court' => $court,
            'data' => $slots
        ];


        return response($response, 200);

    }
}
