<?php

namespace Webqam\EmailAttachment\Preference\Magento\Sales\Model\Order\Email;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Webqam\EmailAttachment\Mail\Template\TransportBuilder;
use Webqam\EmailAttachment\Model\Order\Email\Container\AttachmentIdentityInterface;

class SenderBuilder extends \Magento\Sales\Model\Order\Email\SenderBuilder
{
    /** @var TransportBuilder */
    protected $transportBuilder;

    /**
     * Prepare and send email message
     *
     * @return void
     * @throws LocalizedException
     * @throws MailException
     */
    public function send()
    {
        $this->configureEmailTemplate();

        $this->transportBuilder->addTo(
            $this->identityContainer->getCustomerEmail(),
            $this->identityContainer->getCustomerName()
        );

        // Webqam START
        $templateVars = $this->templateContainer->getTemplateVars();
        if (isset($templateVars[AttachmentIdentityInterface::KEY_TEMPLATE_VARS_EMAIL_ATTACHMENTS_DATA])) {
            $attachments = $templateVars[AttachmentIdentityInterface::KEY_TEMPLATE_VARS_EMAIL_ATTACHMENTS_DATA];
            foreach ($attachments as $attachment) {
                $this->transportBuilder->addAttachment(
                    $attachment[AttachmentIdentityInterface::KEY_ATTACHMENT_CONTENT],
                    $attachment[AttachmentIdentityInterface::KEY_ATTACHMENT_FILE_NAME],
                    $attachment[AttachmentIdentityInterface::KEY_ATTACHMENT_FILE_TYPE]
                );
            }
        }
        // Webqam END

        $copyTo = $this->identityContainer->getEmailCopyTo();

        if (!empty($copyTo) && $this->identityContainer->getCopyMethod() == 'bcc') {
            foreach ($copyTo as $email) {
                $this->transportBuilder->addBcc($email);
            }
        }

        $transport = $this->transportBuilder->getTransport();
        $transport->sendMessage();
    }
}
