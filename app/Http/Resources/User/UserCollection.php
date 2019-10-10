<?php

namespace App\Http\Resources\User;

use App\Http\Resources\ApiCollection;

use App\Models\User;

class UserCollection extends ApiCollection
{
   /**
    * Transform the resource collection into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
   public function toArray($request)
   {
       $this->collection->transform(function (User $user) {
           return new UserResource($user);
       });

       return parent::toArray($request);
   }
}