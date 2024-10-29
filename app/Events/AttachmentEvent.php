<?php

namespace App\Events;

class AttachmentEvent
{
    public $attachments;

    public $model;

    public function __construct($model, $attachments)
    {
        $this->model = $model;
        $this->attachments = $attachments;
    }
}
