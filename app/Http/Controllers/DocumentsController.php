<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DocumentsController extends Controller
{
    protected $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function show($file = null)
    {
        /*
        return view('documents.index', [
            'index' => markdown($this->document->get()),
            'content' => markdown($this->document->get($file ?: 'index.md'))
        ]);
        */
        $index = Cache::remember('documents.index', 120, function () {
            return markdown($this->document->get());
        });

        $content = Cache::remember('documents.{$file}', 120, function () use ($file) {
            return markdown($this->document->get($file));
        });

        return view('documents.index', compact('index', 'content'));
    }
}
