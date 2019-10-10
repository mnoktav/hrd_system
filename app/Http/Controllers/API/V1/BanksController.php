<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Validator;
use App\Models\Bank;
use App\Http\Resources\BankResource;
use Illuminate\Support\Str;


class BanksController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::paginate();
        
        return BankResource::collection($banks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account' => 'required|string',
            'id_user' => 'required',
            'bank' => 'required',
            'number' => 'required',
        ]);
    
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $bank = Bank::create([    
            'uuid' => Str::uuid()->toString(),
            'account' => $request->account,
            'number' => $request->number,
            'bank' => $request->bank,
            'id_user' => $request->id_user
        ]);

        return response()->json(['message' => 'Successfully created bank account'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $bank = Bank::where('uuid',$uuid)->count();
        if($bank < 1){
            return response()->json(['message' => 'Resource not found'], 404);
        }

        return new BankResource($bank);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'account' => 'required|string',
            'id_user' => 'required',
            'bank' => 'required',
            'number' => 'required',
        ]);
    
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $bank = Bank::where('uuid',$uuid)->count();
        if($bank < 1){
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $bank = Bank::where('uuid',$uuid)
                    ->update([
                        'account' => $request->account,
                        'id_user' => $request->id_user,
                        'bank' => $request->bank,
                        'number' => $request->number,
                    ]);
        
        return response()->json([
            'message' => 'Successfully updated bank account'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $bank = Bank::where('uuid',$uuid)->count();
        if($bank < 1){
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $bank = Bank::where('uuid',$uuid)->delete();
        
        return response()->json(['message' => 'Successfully deleted bank account'], 200);
    }
}
