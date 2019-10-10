<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Company;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\Company\CompanyCollection;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;


class CompanyController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::paginate();
        
        return CompanyResource::collection($companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        DB::connection('mysql')->beginTransaction();
        $company = new Company;
        $company->uuid             = Str::uuid()->toString();
        $company->name             = $request->name;
        $company->information      = $request->information;
        
        
        if($company->save()){
            DB::connection('mysql')->commit();
            return response()->json(['message' => 'Successfully created company'],201);
            
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json(['message' => "Can't create company"],500);
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
        $company = Company::findOrFailByUuid($uuid);

        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, $uuid)
    {
        DB::connection('mysql')->beginTransaction();
        //check user
        $company = Company::findOrFailByUuid($uuid);
        $company->name             = $request->name;
        $company->information      = $request->information;

        if($company->save()){
            DB::connection('mysql')->commit();
            return response()->json([
                'message' => 'Successfully updated company'
            ], 200);
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json([
                'message' => "Can't update company"
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
        $company = Company::findOrFailByUuid($uuid);

        if($company->delete()){
            DB::connection('mysql')->commit();
            return response()->json(['message' => 'Successfully deleted company'], 200);
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json(['message' => "Can't delete company"], 500);
        }
    }
}
