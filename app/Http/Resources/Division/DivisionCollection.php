<?php

namespace App\Http\Resources\Division;

use App\Http\Resources\ApiCollection;

use App\Models\Division;

class DivisionCollection extends ApiCollection
{
   /**
    * Transform the resource collection into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
   public function toArray($request)
   {
       $this->collection->transform(function (Division $division) {
           return new DivisionResource($division);
       });

       return parent::toArray($request);
   }
}