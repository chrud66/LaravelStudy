<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttachmentsController extends Controller
{
    public function store(Request $request)
    {
        if (! $request->hasFile('file')) {
            return response()->json('File not passed', 422);
        };

        $file = $request->file('file');
        $name = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $file->move(attachment_path(), $name);

        $articleId = $request->input('articleId');
        $createData = ['name' => $name];

        $attachment = $articleId
        ? \App\Article::findOrFail($articleId)->attachments()->create($createData)
        : \App\Attachment::create($createData);

        return response()->json([
            'id'    => $attachment->id,
            'name'  => $name,
            'type'  => $file->getClientMimeType(),
            'url'   => sprintf("/attachments/%s", $name),
        ]);
    }

    public function destroy($id)
    {
        $attachment = \App\Attachment::findOrFail($id);

        $path = attachment_path($attachment->name);
        if (\File::exists($path)) {
            \File::delete($path);
        };

        $attachment->delete();

        if (\Request::ajax()) {
            return response()->json(['status' => 'ok']);
        };

        flash()->success(__('forum.deleted_file'));

        return back();
    }
}
