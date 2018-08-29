<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use \Spatie\PdfToImage\Pdf as Pdf;

class pdfToImgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pdfToImg.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $basePath = 'public' . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR;

        $filePath = $basePath . $id;
        $imgSavePath = storage_path('app') . DIRECTORY_SEPARATOR . $basePath . 'images' . DIRECTORY_SEPARATOR;
        $storagePath = storage_path('app') . DIRECTORY_SEPARATOR . $filePath;

        if (! Storage::exists($filePath)) {
            flash()->error('요청하신 PDF 파일이 없습니다.');
            return redirect(route('pdf-to-img.index'));
        };

        $fileName = pathinfo($storagePath, PATHINFO_FILENAME);

        $pdf = new Pdf($storagePath);
        $pdf->setCompressionQuality(100);

        $arrImgName = [];
        foreach (range(1, $pdf->getNumberOfPages()) as $pageNum) {
            $pdf->setPage($pageNum)->saveImage($imgSavePath . $fileName . '_page' . $pageNum . '.jpg');

            $arrImgName[] = $fileName . '_page' . $pageNum . '.jpg';
        };


        return view('pdfToImg.show', compact('arrImgName'));
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

        $filePath = 'public' . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $fileName;

        if (! Storage::exists($filePath)) {
            abort(404);
        };

        $downPath = 'app' . DIRECTORY_SEPARATOR . $filePath;

        return response()->download(storage_path($downPath));
    }

    public function allDownload(Request $request)
    {
        $fileNames = $request->input('imgFiles');

        if (! count($fileNames)) {
            flash()->error('이미지 파일이 없습니다.');
            return back();
        };

        $zipPath = 'storage' . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR . 'zip' . DIRECTORY_SEPARATOR . time() . '_all_images.zip';

        $folderPath = 'storage' . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR . 'images';

        $arrFilePaths = [];

        foreach ($fileNames as $fileName) {
            $filePath = 'public' . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $fileName;

            if (! Storage::exists($filePath)) {
                abort(404);
            };

            $arrFilePaths[] = $folderPath . DIRECTORY_SEPARATOR . $fileName;
        };

        \Zipper::make($zipPath)->add($arrFilePaths);

        //return response()->download(storage_path($downPath));
        return null;
    }
}
