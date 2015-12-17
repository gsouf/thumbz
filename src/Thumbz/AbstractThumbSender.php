<?php

namespace Thumbz;


abstract class AbstractThumbSender {

    abstract public function send(Thumb $thumb);

}