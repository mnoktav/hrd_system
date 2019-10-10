<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\ApiCollection;

use App\Models\Company;

class CompanyCollection extends ApiCollection
{
   /**
    * Transform the resource collection into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
   public function toArray($request)
   {
       $this->collection->transform(function (Company $company) {
           return new CompanyResource($company);
       });

       return parent::toArray($request);
   }
}