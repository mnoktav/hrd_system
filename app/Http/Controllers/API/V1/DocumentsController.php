<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Validator;
use App\Models\Document;
use App\Http\Resources\DocumentResource;
use Illuminate\Support\Str;


class DocumentsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::paginate();
        
        return DocumentResource::collection($documents);
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
            'doc_type' => 'required|string',
            'id_user' => 'required',
        ]);
    
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $document = Document::create([ 
            'uuid' => Str::uuid()->toString(),   
            'doc_type' => $request->doc_type,
            'doc_link' => $request->doc_link,
            'doc_number' => $request->doc_number,
            'id_user' => $request->id_user
        ]);

        return response()->json(['message' => 'Successfully created document'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $document = Document::where('uuid',$uuid)->count();
        if($document < 1){
            return response()->json(['message' => 'Resource not found'], 404);
        }

        return new DocumentResource($document);
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
            'doc_type' => 'required|string',
            'id_user' => 'required',
        ]);
    
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $document = Document::where('uuid',$uuid)->count();
        if($document < 1){
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $document = Document::where('uuid',$uuid)
                    ->update([
                        'doc_type' => $request->doc_type,
                        'id_user' => $request->id_user,
                        'bank' => $request->bank,
                        'number' => $request->number,
                    ]);
        
        return response()->json([
            'message' => 'Successfully updated document'
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
        $document = Document::where('uuid',$uuid)->count();
        if($document < 1){
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $document = Document::where('uuid',$uuid)->delete();
        
        return response()->json(['message' => 'Successfully deleted document'], 200);
    }
}
