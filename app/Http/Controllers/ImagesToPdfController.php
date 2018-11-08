<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use File;
use Imagick;

class ImagesToPdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('imagesToPdf.index');
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
        $fileList = json_decode($request->fileList);

        $basePath = public_path('storage' . DIRECTORY_SEPARATOR . 'imgToPdfs' . DIRECTORY_SEPARATOR);
        $fileName = time() . '_Convert.pdf';
        $savePath = $basePath . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR . $fileName;

        $filePaths = [];
        $imgick = new Imagick();

        foreach ($fileList as $key => $value) {
            $filePath = $basePath . $value->name;
            $filePaths[] = $filePath;

            if (! File::exists($filePath)) {
                return response()->json([
                    'status' => 'failed',
                    'message' => '요청하신 파일이 없습니다.',
                ], 404);
            };
        };

        $imgick->readImages($filePaths);
        $imgick->resetIterator();
        $combined = $imgick->appendImages(true);

        /* Output the image */
        $combined->setImageFormat("pdf");
        /* Save PDF File */
        $combined->writeImage($savePath);

        return response()->json([
            'status' => 'success',
            'pdfName' => $fileName,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $basePath = public_path('storage' . DIRECTORY_SEPARATOR . 'imgToPdfs' . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR);
        $filePath = $basePath . $id;

        if (! File::exists($filePath)) {
            flash()->error('존재하지 않는 PDF 파일입니다.');
            return redirect(route('images-to-pdf.index'));
        };

        return response()->download($filePath);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download($fileName)
    {
        //
    }

    public function fileUpload(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json('File not passed', 422);
        };

        $file = $request->file('file');

        $ext = $file->getClientOriginalExtension();
        $name = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

        if($ext !== 'png' && $ext !== 'jpg' && $ext !== 'jpeg') {
            return response()->json('png, jpg 파일만 업로드 할 수 있습니다.', 406);
        };

        $detailPath = 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'imgToPdfs' . DIRECTORY_SEPARATOR;
        $file->move(storage_path($detailPath), $name);

        return response()->json([
            'id'   => $name,
            'name' => $name,
            'type' => $file->getClientMimeType(),
            'url'  => Storage::url($detailPath . $name),
        ]);

    }

    public function fileDestroy(Request $request)
    {
        $fileName = $request->input('fileName');

        $deletePath = 'public' . DIRECTORY_SEPARATOR . 'imgToPdfs' . DIRECTORY_SEPARATOR . $fileName;

        if (Storage::exists($deletePath)) {
            Storage::delete($deletePath);
        };

        if (\Request::ajax()) {
            return response()->json(['status' => 'ok']);
        };

        flash()->success(__('forum.deleted_file'));

        return back();
    }
}
