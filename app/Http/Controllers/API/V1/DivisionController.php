<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Division;
use App\Http\Resources\Division\DivisionResource;
use App\Http\Resources\Division\DivisionCollection;

use App\Http\Requests\Division\StoreDivisionRequest;
use App\Http\Requests\Division\UpdateDivisionRequest;


class DivisionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Division::paginate();
        
        return DivisionResource::collection($divisions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDivisionRequest $request)
    {
        DB::connection('mysql')->beginTransaction();
        $division = new Division;
        $division->uuid             = Str::uuid()->toString();
        $division->name             = $request->name;
        $division->information      = $request->information;
        $division->id_branch       = $request->id_branch;
    
        if($division->save()){
            DB::connection('mysql')->commit();
            return response()->json(['message' => 'Successfully created division'],201);
            
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json(['message' => "Can't create division"],500);
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
        $division = Division::findOrFailByUuid($uuid);

        return new DivisionResource($division);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDivisionRequest $request, $uuid)
    {
        DB::connection('mysql')->beginTransaction();
        //check user
        $division = Division::findOrFailByUuid($uuid);
        $division->name             = $request->name;
        $division->information      = $request->information;

        if($division->save()){
            DB::connection('mysql')->commit();
            return response()->json([
                'message' => 'Successfully updated division'
            ], 200);
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json([
                'message' => "Can't update division"
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
        $division = Division::findOrFailByUuid($uuid);

        if($division->delete()){
            DB::connection('mysql')->commit();
            return response()->json(['message' => 'Successfully deleted division'], 200);
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json(['message' => "Can't delete division"], 500);
        }
    }
}
