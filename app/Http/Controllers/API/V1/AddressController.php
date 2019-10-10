<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Address;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Address\AddressCollection;

use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;


class AddressController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::paginate();
        
        return AddressResource::collection($addresses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressRequest $request)
    {
        DB::connection('mysql')->beginTransaction();
        $address = new Address;
        $address->uuid             = Str::uuid()->toString();
        $address->id_user          = $request->id_user;
        $address->type             = $request->type;
        $address->address          = $request->address;
        
        if($address->save()){
            DB::connection('mysql')->commit();
            return response()->json(['message' => 'Successfully created address'],201);
            
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json(['message' => "Can't create address"],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $address = Address::findOrFailByUuid($uuid);

        return new AddressResource($address);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddressRequest $request, $uuid)
    {
        DB::connection('mysql')->beginTransaction();
        //check user
        $address = Address::findOrFailByUuid($uuid);
        $address->type             = $request->type;
        $address->address          = $request->address;
        $address->id_user          = $request->id_user;

        if($address->save()){
            DB::connection('mysql')->commit();
            return response()->json([
                'message' => 'Successfully updated address'
            ], 200);
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json([
                'message' => "Can't update address"
            ], 422);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        DB::connection('mysql')->beginTransaction();
        $address = Address::findOrFailByUuid($uuid);

        if($address->delete()){
            DB::connection('mysql')->commit();
            return response()->json(['message' => 'Successfully deleted address'], 200);
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json(['message' => "Can't delete address"], 500);
        }
    }
}
