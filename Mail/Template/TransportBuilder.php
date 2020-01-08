<?php

namespace Webqam\EmailAttachment\Mail\Template;

use Magento\Framework\Exception\LocalizedException;
use Webqam\EmailAttachment\Mail\Message;

class TransportBuilder extends \Magento\Framework\Mail\Template\TransportBuilder
{
    /**
     * @var Message
     */
    protected $message;

    /**
     * Add an attachment to the message.
     *
     * @param string $content
     * @param string $fileName
     * @param string $fileType
     * @return $this
     */
    public function addAttachment($content, $fileName, $fileType)
    {
        $this->message->setBodyAttachment($content, $fileName, $fileType);

        return $this;
    }

    /**
     * After all parts are set, add them to message body.
     *
     * @return $this
     * @throws LocalizedException
     */
    protected function prepareMessage()
    {
        parent::prepareMessage();

        $this->message->setPartsToBody();

        return $this;
    }
}
