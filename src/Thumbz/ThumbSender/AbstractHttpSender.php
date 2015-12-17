<?php


namespace Thumbz\ThumbSender;


use Thumbz\AbstractThumbSender;
use Thumbz\Thumb;

abstract class AbstractHttpSender  extends AbstractThumbSender{

    protected $clientCacheTime;

    function __construct($clientCacheTime = 0)
    {
        $this->clientCacheTime = $clientCacheTime;
    }


    public function send(Thumb $thumb){

        if($this->clientCacheTime > 0){
            header('Pragma: public');
            header('Cache-Control: max-age=' . $this->clientCacheTime);
            header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + $this->clientCacheTime));
            header('Content-Type: image/' . $thumb->getExtension());
        }

        $this->httpSend($thumb);
    }

    abstract public function httpSend(Thumb $thumb);


}