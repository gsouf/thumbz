<?php

namespace Thumbz\ThumbSender;

use Thumbz\AbstractThumbCache;
use Thumbz\AbstractThumbSender;
use Thumbz\Thumb;

class ApacheXSendFileSender extends AbstractHttpSender {
    public function httpSend(Thumb $thumb)
    {
        header('X-Sendfile: ' . $thumb->getCacheName());
    }
}