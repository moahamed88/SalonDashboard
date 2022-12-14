<?php

namespace App\Http\Controllers\Api\Order;
use App\Http\Resources\Order\BookingCollection;
use App\Http\Resources\Order\BokingResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\Booking\Boking;
use App\Http\Resources\Offers\OffersResources;
use App\Models\Booking;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offersOrders=Boking::collection(Booking::with('order')->get());
        return $offersOrders;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=$this->validate($request,[
            'note' => 'required',
            'address' => 'required',
             'salon_id'=> 'required',
             'services' => 'required:services.*.service_id|exists:services,id',
        
        ]
    ); //
   
        $orderData = $request;
        DB::beginTransaction();
    $order=Booking::create([
        'note'=>$request->note,
        'address'=>$request->address,
        // 'long'=>$request->long,
        // 'lat'=>$request->lat,
        'salon_id'=>$request->salon_id,
        'user_id'=>auth()->user()->id,
        
        // 'service_id'=>$request->service_id,
        'amount'=>$request->amount
    ]);
    logger(isset($orderData->services[0]['service_id'])==true?$orderData->services[0]['service_id']:"aaa");

    $order->services()->sync($orderData->services);

    DB::commit();

    return $this->sendResponse($order,["success"]);
    try{
        DB::beginTransaction();

    }catch(Exception $ex){
        DB::rollBack();

    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
