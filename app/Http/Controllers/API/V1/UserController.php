<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;


class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate();
        return UserResource::collection($users);
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        DB::connection('mysql')->beginTransaction();
        $user = new User;
        $user->uuid              = Str::uuid()->toString();
        $user->first_name       = $request->first_name;
        $user->last_name        = $request->last_name;
        $user->middle_name      = $request->middle_name;
        $user->nik              = $request->nik;
        $user->emp_status       = $request->emp_status;
        $user->position         = $request->position;
        $user->probation_date   = $request->probation_date;
        $user->entry_date       = $request->entry_date;
        $user->out_date         = $request->out_date;
        $user->birthday         = $request->birthday;
        $user->place_of_birth   = $request->place_of_birth;
        $user->npwp             = $request->npwp;
        $user->email            = $request->email;
        $user->password         = Hash::make($request->password);
        $user->position         = $request->position;
        $user->account_status   = 1;
        $user->is_superadmin    = 0;
        
        if($user->save()){
            DB::connection('mysql')->commit();
            return response()->json(['message' => 'Successfully created user'],201);
            
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json(['message' => "Can't create user"],500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $user = User::findOrFailByUuid($uuid);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $uuid)
    {
        DB::connection('mysql')->beginTransaction();
        //check user
        $user = User::findOrFailByUuid($uuid);

        $user->uuid             = Str::uuid()->toString();
        $user->first_name       = $request->first_name;
        $user->last_name        = $request->last_name;
        $user->middle_name      = $request->middle_name;
        $user->nik              = $request->nik;
        $user->emp_status       = $request->emp_status;
        $user->position         = $request->position;
        $user->probation_date   = $request->probation_date;
        $user->entry_date       = $request->entry_date;
        $user->out_date         = $request->out_date;
        $user->birthday         = $request->birthday;
        $user->place_of_birth   = $request->place_of_birth;
        $user->npwp             = $request->npwp;
        $user->email            = $request->email;
        $user->password         = Hash::make($request->password);
        $user->position         = $request->position;
        $user->account_status   = 1;
        $user->is_superadmin    = 0;

        $check_email = User::whereNotIn('uuid',[$uuid])
                        ->where('email',$request->email)
                        ->count();

        if ($check_email > 0) {
            return response()->json(['error' => 'Email has been already taken'], 422);
        }
        if($user->save()){
            DB::connection('mysql')->commit();
            return response()->json([
                'message' => 'Successfully updated user'
            ], 200);
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json([
                'message' => "Can't update user"
            ], 422);
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        DB::connection('mysql')->beginTransaction();
        $user = User::findOrFailByUuid($uuid);

        if($user->delete()){
            DB::connection('mysql')->commit();
            return response()->json(['message' => 'Successfully deleted user'], 200);
        }else{
            DB::connection('mysql')->rollBack();
            return response()->json(['message' => "Can't delete user"], 500);
        }
        
    }
}
