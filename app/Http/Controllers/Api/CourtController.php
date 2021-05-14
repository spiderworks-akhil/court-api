<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Court;
use App\Models\Day;
use App\Models\Holiday;
use App\Models\Payment;
use App\Models\SlotHistory;
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
            'status' => true,
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
                'status' => false,
                'message' => 'Court not found',
            ];
            return response($response, 200);
        }
        $d = Carbon::parse($date)->format('l');
        $day = Day::where('name',$d)->first();
        $holiday = Holiday::where('date',$date)->first();

        if($holiday){
            $surcharge = $holiday->surcharge;
        }else{$holiday=null;$surcharge =0;}

        $slots = Slots::select('slot_number','price','is_slot_open','status')->where('day_id',$day->id)->where('court_id',$court_id)->orderby('slot_number','ASC')->get();

        if(count($slots) == 0){
            $response = [
                'status' => false,
                'message' => 'No slots added, Please contact directly'
            ];
            return response($response, 200);
        }

        $f = Carbon::parse('00:00:00 1-1-2020');
        $t = Carbon::parse('00:30:00 1-1-2020');

        $slots->map(function ($item)use($surcharge,$f,$t,$holiday,$court_id,$date){
            $item->price = $item->price+$surcharge;
            $item->from =$f->addMinutes(30)->format('H:i');
            $item->to =$t->addMinutes(30)->format('H:i');
            $item->slot_time = $f->addMinutes(30)->format('H:i').' - '.$t->addMinutes(30)->format('H:i');
            if(!empty($holiday)){
                $item->is_slot_open = $holiday->is_business_open;
            }

            $slot_check = SlotHistory::where('court_id',$court_id)->where('slot',$item->slot_number)->where('date',$date)->first();
            if($slot_check){
                $item->status = 2;
            }
            return $item;
        });


        $slot_status = [
          1=>'available',
          2=>'booked'
        ];
        $response = [
            'status' => true,
            'holiday' => $holiday,
            'day' => $d,
            'court' => $court,
            'data' => $slots,
            'slot_status' => $slot_status
        ];


        return response($response, 200);

    }

    public function get_estimate(Request $request){

        $user = $request->user();
        if(!$user){
            $response = [
                'status' => false,
                'message' => 'User not found!'
            ];
            return response($response, 200);
        }

        $court = Court::find($request->court_id);
        if(!$court){
            $response = [
                'status' => false,
                'message' => 'Court not found!'
            ];
            return response($response, 200);
        }

        if(empty($request->start_slot) || empty($request->end_slot) || empty($request->start_slot_date)  || empty($request->end_slot_date) ){
            $response = [
                'status' => false,
                'message' => 'Slot not valid'
            ];
            return response($response, 200);
        }







        $slots = $this->slots($request->start_slot,$request->end_slot,$request->start_slot_date,$request->end_slot_date,$court->id);

        $total = 0;
        foreach ($slots as $obj){
            $slot_check = SlotHistory::where('slot',$obj['slot'])->where('court_id',$court->id)->where('date',$obj['date'])->first();
            if($slot_check){
                $response = [
                    'status' => false,
                    'message' => 'Some of slots not available, please check the availability of the slots'
                ];
                return response($response, 200);
            }
            $total += $obj['price'];
        }

        if(!empty($user->phone)){
            $phone = $user->phone;
        }else{
            $phone = 'false';
        }




        $response = $response = [
            'status' => true,
            'message' => 'Price list',
            'slots' => $slots,
            'total' => $total,
            'phone' => $phone
        ];


        return response($response, 200);
    }

    public function book_court(Request $request){

        $user = $request->user();
            if(!$user){
                $response = [
                    'status' => false,
                    'message' => 'User not found!'
                ];
                return response($response, 200);
            }

        $court = Court::find($request->court_id);
            if(!$court){
                $response = [
                    'status' => false,
                    'message' => 'Court not found!'
                ];
                return response($response, 200);
            }

            if(empty($request->start_slot) || empty($request->end_slot) || empty($request->start_slot_date)  || empty($request->end_slot_date) ){
                $response = [
                    'status' => false,
                    'message' => 'Slot not valid'
                ];
                return response($response, 200);
            }





        $booking = new Booking();
        $booking->user_id = $user->id;
        $booking->court_id = $court->id;
        $booking->start_slot = $request->start_slot;
        $booking->end_slot = $request->end_slot;

        $booking->start_slot_date = $request->start_slot_date;
        $booking->end_slot_date = $request->end_slot_date;

        $slots = $this->slots($request->start_slot,$request->end_slot,$request->start_slot_date,$request->end_slot_date,$court->id);

        $total = 0;
        foreach ($slots as $obj){
            $slot_check = SlotHistory::where('slot',$obj['slot'])->where('court_id',$court->id)->where('date',$obj['date'])->first();
            if($slot_check){
                $response = [
                    'status' => false,
                    'message' => 'Some of slots not available, please check the availability of the slots'
                ];
                return response($response, 200);
            }
            $total += $obj['price'];
        }


        $booking->total = $total;
        $booking->discount = $request->discount? $request->discount : 0;
        $booking->paid_amount = $request->paid_amout? $request->paid_amout : 0;
        if($booking->paid_amount == $booking->total){
            $booking->status = 2;
        }else{
            $booking->status = 1;
        }
        $booking->approved_by = null;
        $booking->price_calculation = json_encode($slots);



        if($booking->paid_amount > 0){
            $payment = new Payment();
            $payment->booking_id = $booking->id;
            $payment->amount = $booking->paid_amount;
            $payment->reference =  'Initial payment';
            $payment->added_by = $user->id;
            $payment->save();
        }

        if($booking->paid_amount == $booking->total){
            $booking->status = 4;
        }elseif ($booking->paid_amount > 0){
            $booking->status = 2;
        }

        $booking->save();

        foreach ($slots as $obj){
            $slot_check = SlotHistory::where('slot',$obj['slot'])->where('court_id',$obj['slot'])->where('date',$obj['date'])->first();
            if($slot_check){
                $response = [
                    'status' => false,
                    'message' => 'Some of slots not available, please check the availability of the slots'
                ];
                return response($response, 200);
            }else{
                $history = new SlotHistory();
                $history->booking_id = $booking->id;
                $history->slot = $obj['slot'];
                $history->date = $obj['date'];
                $history->court_id = $court->id;
                $history->save();

            }
        }

        $response = $response = [
            'status' => true,
            'message' => 'Booking created',
            'data' => $booking,
            'booking_status' => $this->payment_response()
        ];

        if(!empty($user->firebase_token)){
           $this->send_notification($user->firebase_token,'Booking registered','Waiting for the confirmation');
        }

        return response($response, 200);
    }

    public function payment_response(){
        return [
            0 => 'Booking cancelled',
            1 => 'Booking Created',
            2 => 'Partially paid',
            4 => 'Payment completed',
            3 => 'Booking Approved'
        ];
    }

    public function price_of_slot($slot,$date,$court){
        $court_id = $court;
        $court = Court::select('name')->find($court_id);
        if(!$court){
            $response = [
                'status' => false,
                'message' => 'Court not found',
            ];
            return response($response, 200);
        }
        $d = Carbon::parse($date)->format('l');
        $day = Day::where('name',$d)->first();
        $holiday = Holiday::where('date',$date)->first();

        if($holiday){
            $surcharge = $holiday->surcharge;
        }else{
            $holiday=null;$surcharge =0;
        }

        $slot = Slots::select('slot_number','price','is_slot_open','status')->where('day_id',$day->id)->where('court_id',$court_id)->orderby('slot_number','ASC')->first();
        return $slot->price = $slot->price+$surcharge;
    }

    public function slots($from,$to,$from_date,$to_date,$court){



        #48 slots per day
        if($from_date == $to_date){
            $slots = $to - $from;
            $data = [];
            for($i=$from;$i<=$to;$i++){
                $a=[];
                $a['date'] = $from_date;
                $a['slot'] = $i;
                $a['price'] = $this->price_of_slot($a['slot'],$a['date'],$court);
                $f = Carbon::parse('00:00:00 1-1-2020');
                $t = Carbon::parse('00:30:00 1-1-2020');
                $fr =$f->addMinutes(30*$i)->format('H:i');
                $tu =$t->addMinutes(30*$i)->format('H:i');
                $a['from'] = $fr;
                $a['to'] = $tu;
                array_push($data, $a);
            }
        }else{
            $days_difference = Carbon::parse($to_date)->diffInDays(Carbon::parse($from_date));
            $dates = [];
            $dates['dates'] = [];
            $data = [];
            for ($i=0;$i<=$days_difference;$i++){
                if($i==0){
                    $dates['from'] = Carbon::parse($from_date)->addDays($i)->format('Y-m-d');
                }elseif($i==$days_difference){
                    $dates['to'] = Carbon::parse($from_date)->addDays($i)->format('Y-m-d');
                }else{
                    array_push($dates['dates'],Carbon::parse($from_date)->addDays($i)->format('Y-m-d'));
                }
            }

            //From slots

                for($i=$from;$i<=48;$i++){
                    $a=[];
                    $a['date'] = $dates['from'];
                    $a['slot'] = $i;
                    $a['price'] = $this->price_of_slot($a['slot'],$a['date'],$court);
                    $f = Carbon::parse('00:00:00 1-1-2020');
                    $t = Carbon::parse('00:30:00 1-1-2020');
                    $fr =$f->addMinutes(30*$i)->format('H:i');
                    $tu =$t->addMinutes(30*$i)->format('H:i');
                    $a['from'] = $fr;
                    $a['to'] = $tu;
                    array_push($data, $a);
                }


            //Middle slots

            if(!empty($dates['dates'])){
                foreach ($dates['dates'] as $obj){
                    for($i=1;$i<=48;$i++){
                        $a=[];
                        $a['date'] = $obj;
                        $a['slot'] = $i;
                        $a['price'] = $this->price_of_slot($a['slot'],$a['date'],$court);
                        $f = Carbon::parse('00:00:00 1-1-2020');
                        $t = Carbon::parse('00:30:00 1-1-2020');
                        $fr =$f->addMinutes(30*$i)->format('H:i');
                        $tu =$t->addMinutes(30*$i)->format('H:i');
                        $a['from'] = $fr;
                        $a['to'] = $tu;
                        array_push($data, $a);
                    }
                }
            }

            //End slots

                for($i=1;$i<=$to;$i++){
                    $a=[];
                    $a['date'] = $dates['to'];
                    $a['slot'] = $i;
                    $a['price'] = $this->price_of_slot($a['slot'],$a['date'],$court);
                    $f = Carbon::parse('00:00:00 1-1-2020');
                    $t = Carbon::parse('00:30:00 1-1-2020');
                    $fr =$f->addMinutes(30*$i)->format('H:i');
                    $tu =$t->addMinutes(30*$i)->format('H:i');
                    $a['from'] = $fr;
                    $a['to'] = $tu;
                    array_push($data, $a);
                }


        }

        return $data;



    }

    public function get_my_booking(Request $request){
        $user = $request->user();
        $bookings =  Booking::where('user_id',$user->id)->with('court')->orderby('id','DESC')->paginate(10);

        $response = [
            'status' => true,
            'user' => $user,
            'data' => $bookings
        ];
        return response($response, 200);
    }

    public function add_phone(Request $request){
        $user = $request->user();
        $user->phone = $request->phone;
        if(strlen($request->phone) !== 10){
            $response = [
                'status' => false,
                'message' => 'Phone number must be 10 digits'
            ];
        }else{
            $user->save();

            $response = [
                'status' => true,
                'user' => $user
            ];
        }

        return response($response, 200);
    }



    public function get_all_booking(Request $request){
        $user = $request->user();
//        if($user->is_Admin !== 1){
//            $response = [
//                'status' => false,
//                'message' => 'Access denied'
//            ];
//            return response($response, 403);
//        }
        $bookings =  Booking::orderby('id','desc');
        if(!empty($request->status)){
            $bookings->where('status',$request->status);
        }
        $bookings = $bookings->with('user')->paginate(10);
        $response = [
            'status' => true,
            'data' => $bookings
        ];
        return response($response, 200);
    }

    public function add_payment(Request $request){
$user = $request->user();
//        if($user->is_Admin !== 1){
//            $response = [
//                'status' => false,
//                'message' => 'Access denied'
//            ];
//            return response($response, 403);
//        }
$booking =  Booking::find($request->booking_id);
if(!$booking){
$response = [
'status' => false,
'message' => 'Booking not found'
];
return response($response, 403);
}
$pending_amount = $booking->total - $booking->paid_amount;


if($pending_amount < $request->amount){
    $response = [
        'status' => false,
        'message' => 'Amount mismatch, Please check the amount'
    ];
    return response($response, 403);
}

if($request->amount == $pending_amount){
    $booking->status = 4;
}else{
    $booking->status = 2;
}


$booking->paid_amount = $booking->paid_amount+$request->amount;
$payment = new Payment();
$payment->booking_id = $booking->id;
$payment->amount = $request->amount;
$payment->reference =  $request->reference;
$payment->added_by = $user->id;
$payment->save();
$booking->save();



$response = [
    'status' => true,
    'data' => $payment,
    'booking' => $booking
];
return response($response, 200);
}

    public function booking_details(Request $request){
        $booking = Booking::where('id',$request->booking_id)->with('payment_history')->with('court')->get();

        $response = [
            'status' => true,
            'booking' => $booking
        ];

        return response($response, 200);

    }

    public function change_booking_status(Request $request){
        $user = $request->user();

        $booking = Booking::where('id',$request->booking_id)->with('payment_history')->first();
        $booking->status = $request->status;
        $booking->approved_by = $user->id;
        $booking->save();

        if($booking->status == 0 && !empty($user->firebase_token)){
         return   $this->send_notification($user->firebase_token,'Oh.. Your booking is cancelled','Something happened. please try again later');
        }

        $response = [
            'status' => true,
            'booking' => $booking,
            'booking_status' => $this->payment_response()
        ];

        return response($response, 200);

    }

    public function firebase_token_store(Request $request){

        $user = $request->user();
        $user->firebase_token = $request->firebase_token;
        $status = $user->save();
        if($status){
            $response = [
                'status' => true,
                'user' => $user
            ];
        }else{
            $response = [
                'status' => false,
                'user' => $user
            ];
        }


        return response($response, 200);
    }


}
