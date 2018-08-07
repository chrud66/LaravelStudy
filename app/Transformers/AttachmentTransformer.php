<?php

namespace App\Transformers;

use App\Attachment;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class AttachmentTransformer extends TransformerAbstract
{
    /**
     * List of attributes to respond.
     *
     * @var  array
     */
    protected $visible = [];

    /**
     * List of attributes NOT to respond.
     *
     * @var  array
     */
    protected $hidden = [];

    /**
     * Transform single resource.
     *
     * @param  \App\Attachment $attachment
     * @return  array
     */
    public function transform(Attachment $attachment)
    {
        $id = optimus((int) $attachment->id);
        $payload = [
            'id' => (int) $id,
            'name' => $attachment->name,
            'created' => $attachment->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.download', $attachment->name),
            ],
        ];

        return $this->buildPayload($payload);
    }
}
