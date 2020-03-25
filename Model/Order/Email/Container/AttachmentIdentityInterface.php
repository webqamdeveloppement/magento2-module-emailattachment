<?php

namespace Webqam\EmailAttachment\Model\Order\Email\Container;

interface AttachmentIdentityInterface
{
    const KEY_TEMPLATE_VARS_EMAIL_ATTACHMENTS_DATA = 'email-attachments-data';
    const KEY_ATTACHMENT_CONTENT = 'content';
    const KEY_ATTACHMENT_FILE_NAME = 'file-name';
    const KEY_ATTACHMENT_FILE_TYPE = 'file-type';
}
