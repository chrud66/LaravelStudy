![](./01-welcome-image-03.png)

```php
namespace App\Http\Controllers;

use App\Document;
use Cache;
use Image;
use Request;

class DocumentsController extends Controller
{
    protected $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function show($file = 'index.md')
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

        //$content = Cache::remember('documents.{$file}', 120,
        $cacheName = 'documents.' . $file;
        $content = Cache::remember($cacheName, 120, function () use ($file) {
            return markdown($this->document->get($file));
        });

        return view('documents.index', compact('index', 'content'));
    }

    public function image($file)
    {
        $image = $this->document->image($file);

        //파일 브라우저 캐시 이용을 위한 etag 비교 로직
        $reqEtag = Request::getEtags();
        $genEtag = $this->document->etag($file);

        if (isset($reqEtag[0]) && $reqEtag[0] === $genEtag) {
            return response('', 304);
        }

        return response($image->encode('png'), 200, [
            'Content-Type'  => 'image/png',
            'Cache-Control' => 'public, max-age=0',
            'Etag'          => $genEtag,
        ]);
    }
```