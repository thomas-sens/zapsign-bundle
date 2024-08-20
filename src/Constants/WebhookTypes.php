<?php
namespace ThomasSens\ZapsignBundle\Constants;

final class WebhookTypes
{
    public const DOC_SIGNED = 'doc_signed';
    public const DOC_CREATED = 'doc_created';
    public const DOC_DELETED = 'doc_deleted';
    public const DOC_REFUSED = 'doc_refused';
    public const EMAIL_BOUNCE = 'email_bounce';
}