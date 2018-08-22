<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class PdfFilesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! $request->hasFile('file')) {
            return response()->json('File not passed', 422);
        };

        $file = $request->file('file');

        if (! $file->getClientOriginalExtension() === 'pdf' && ! $file->getClientMimeType() === 'application/pdf') {
            return response()->json('PDF 파일만 업로드 할 수 있습니다.', 406);
        };

        $name = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $detailPath = 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR;
        $file->move(storage_path($detailPath), $name);

        return response()->json([
            'name' => $name,
            'type' => $file->getClientMimeType(),
            'url'  => Storage::url($detailPath . $name),
        ]);


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
