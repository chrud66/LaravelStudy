<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use File;
use Image;

//class Document extends Model
class Document
{

    private $oriDirectory;
    private $directory;

    public function __construct($directory = 'docs')
    {
        $this->directory = $directory;
        $this->oriDirectory = $directory;
    }

    public function get($file = null)
    {
        $file = $file ? $file : 'index.md';
        return File::get($this->getPath($file));
    }

    public function image($file)
    {
        $this->directory .= DIRECTORY_SEPARATOR . 'images';
        return Image::make($this->getPath($file));
        $this->directory = $this->oriDirectory;
    }

    //파일 브라우저 캐시 이용을 위한 etag 생성 로직
    public function etag($file)
    {
        //return md5($file . '/' . File::lastModified($this->getPath($file)));
        return hash('sha512', $file . '/' . File::lastModified($this->getPath($file)));
    }

    private function getPath($file)
    {
        $path = base_path($this->directory . DIRECTORY_SEPARATOR . $file);

        if (!File::exists($path)) {
            //dd($this->getPath($file));
            abort(404, 'File not exist');
        };
        return $path;
    }
}
