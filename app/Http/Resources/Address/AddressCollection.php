<?php

namespace App\Http\Resources\Address;

use App\Http\Resources\ApiCollection;

use App\Models\Address;

class AddressCollection extends ApiCollection
{
   /**
    * Transform the resource collection into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
   public function toArray($request)
   {
       $this->collection->transform(function (Address $address) {
           return new UserResource($address);
       });

       return parent::toArray($request);
   }
}