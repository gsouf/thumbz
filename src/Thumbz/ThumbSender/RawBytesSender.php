<?php

namespace Thumbz\ThumbSender;

use Thumbz\AbstractThumbCache;
use Thumbz\AbstractThumbSender;
use Thumbz\Thumb;

class RawBytesSender extends AbstractHttpSender {


    public function httpSend(Thumb $thumb)
    {
        echo $thumb->getData();
    }


}