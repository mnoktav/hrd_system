<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Branch;
use App\Http\Resources\Branch\BranchResource;
use App\Http\Resources\Branch\BranchCollection;

use App\Http\Requests\Branch\StoreBranchRequest;
use App\Http\Requests\Branch\UpdateBranchRequest;


class BranchController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::paginate();
        
        return BranchResource::collection($branches);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchRequest $request)
    {
        DB::connection('mysql')->beginTransaction();
        $branch = new Branch;
        $branch->uuid             = Str::uuid()->toString();
        $branch->name             = $request->name;
        $branch->information      = $request->information;
        $branch->id_company       = $request->id_company;
    
        if($branch->save()){
            DB::connection('mysql')->commit();
            return response()->json(['message' => 'Successfully created branch'],201);
            
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json(['message' => "Can't create branch"],500);
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
        $branch = Branch::findOrFailByUuid($uuid);

        return new BranchResource($branch);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBranchRequest $request, $uuid)
    {
        DB::connection('mysql')->beginTransaction();
        //check user
        $branch = Branch::findOrFailByUuid($uuid);
        $branch->name             = $request->name;
        $branch->information      = $request->information;

        if($branch->save()){
            DB::connection('mysql')->commit();
            return response()->json([
                'message' => 'Successfully updated branch'
            ], 200);
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json([
                'message' => "Can't update branch"
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
        $branch = Branch::findOrFailByUuid($uuid);

        if($branch->delete()){
            DB::connection('mysql')->commit();
            return response()->json(['message' => 'Successfully deleted branch'], 200);
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json(['message' => "Can't delete branch"], 500);
        }
    }
}
