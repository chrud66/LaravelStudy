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

        $attachment = \App\Attachment::create(['name' => $name]);

        return response()->json([
            'id'    => $attachment->id,
            'name'  => $name,
            'type'  => $file->getClientMimeType(),
            'url'   => sprintf("/attachments/%s", $name),
        ]);
    }

    public function destroy($id)
    {
    }
}
