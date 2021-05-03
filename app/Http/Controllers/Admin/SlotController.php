<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Day;
use App\Models\Slots;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function index(){
        $courts = Court::all();
        return view('admin.slot.index',compact('courts'));
    }

    public function court($id){
        $court = Court::find(decrypt($id));
        if(!$court){
            abort(404);
        }

        $slots = Slots::where('court_id',$court->id)->get();

        $days = Day::all();

        if(count($slots) != 336){
            $data = [];
            $data['court_id'] = $court->id;
            $data['price'] = 1000;
            $data['is_slot_open'] = 1;
            $data['status'] = 1;

            foreach ($days as $obj){
                for ($i=1;$i<49;$i++){
                    $data['slot_number'] = $i;
                    $data['day_id'] = $obj->id;
                    $slot = Slots::where('court_id',$court->id)->where('slot_number',$i)->where('day_id',$obj->id)->first();
                    if(!$slot){
                        $s = new Slots();
                        $s->fill($data);
                        $s->save();
                    }
                }
            }

        }



        return view('admin.slot.court',compact('court','days'));
    }

    public function change_price(Request $request){
        $slot = Slots::find($request->slot_id);
        if(!$slot){
            $data = [
              'status' => false,
              'message' => 'Slot not found'
            ];
        }
        $slot->price = $request->amount;
        $slot->save();
        if($request->check == 'true'){
            $slots = Slots::where('court_id',$slot->court_id)->where('slot_number',$slot->slot_number)->get();

            foreach ($slots as $obj){
                $s = Slots::find($obj->id);
                $s->price = $request->amount;
                $s->save();
            }
        }

        $data = [
            'status' => true,
            'message' => 'Price details updated'
        ];

        return response($data, 200);
    }
}
