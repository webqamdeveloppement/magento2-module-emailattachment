# Webqam Email Attachment module

## Installation

````bash
composer require webqam/magento2-module-emailattachment
bin/magento setup:upgrade
````

## Usage

### Add attachment on an email

This module add a method to `Magento\Framework\Mail\Template\TransportBuilder` (using Preference).
You can use method addAttachment of [TransportBuilder class](Mail/Template/TransportBuilder.php).

### Attachment for sales order email

use `email_order_set_template_vars_before` observer

````php
use Magento\Framework\DataObject;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Webqam\EmailAttachment\Model\Order\Email\Container\AttachmentIdentityInterface;

class OrderSetTemplateVarsBefore implements ObserverInterface
{
    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(
        Observer $observer
    ) {
        /** @var DataObject $transportObject */
        $transportObject = $observer->getDataByKey('transportObject');
        $attachments = $transportObject->getDataByKey(
            AttachmentIdentityInterface::KEY_TEMPLATE_VARS_EMAIL_ATTACHMENTS_DATA
        );

        $attachment = [
            AttachmentIdentityInterface::KEY_ATTACHMENT_CONTENT   => 'content',
            AttachmentIdentityInterface::KEY_ATTACHMENT_FILE_NAME => 'filename.pdf',
            AttachmentIdentityInterface::KEY_ATTACHMENT_FILE_TYPE => 'pdf'
        ];

        if ($attachments && is_array($attachments)) {
            $attachments[] = $attachment;
            $transportObject->setData(
                AttachmentIdentityInterface::KEY_TEMPLATE_VARS_EMAIL_ATTACHMENTS_DATA,
                $attachments
            );
        } else {
            $transportObject->setData(AttachmentIdentityInterface::KEY_TEMPLATE_VARS_EMAIL_ATTACHMENTS_DATA, [
                $attachment
            ]);
        }
    }
}
````

