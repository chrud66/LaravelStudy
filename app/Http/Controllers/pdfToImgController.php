<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use \Spatie\PdfToImage\Pdf as Pdf;

class PdfToImgController extends Controller
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
            if (! Storage::exists($basePath . 'images' . DIRECTORY_SEPARATOR . $fileName . '_page' . $pageNum . '.jpg')) {
                $pdf->setPage($pageNum)->saveImage($imgSavePath . $fileName . '_page' . $pageNum . '.jpg');
            }

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
            return redirect(route('pdf-to-img.index'));
        };

        //압축파일명
        $zipName = time() . '_all_images.zip';
        //공통 폴더 경로
        $basePath = 'storage' . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR;
        //집파일 저장 경로
        $zipPath = $basePath . 'zips' . DIRECTORY_SEPARATOR . $zipName;
        //이미지 파일들 경로
        $folderPath = $basePath . 'images' . DIRECTORY_SEPARATOR;

        $arrFilePaths = [];

        //이미지 파일들 존재 여부 체크
        foreach ($fileNames as $fileName) {
            $filePath = $folderPath . $fileName;

            if (! \File::exists($filePath)) {
                flash()->error('존재하지 않는 이미지 파일입니다.');
                return redirect(route('pdf-to-img.index'));
            };

            $arrFilePaths[] = $filePath;
        };

        \Zipper::make($zipPath)->add($arrFilePaths)->close();

        if (! \File::exists(public_path($zipPath))) {
            flash()->error('압축파일 생성에 실패하였습니다.');
            return redirect(route('pdf-to-img.index'));
        };

        return response()->download(public_path($zipPath));
    }
}
