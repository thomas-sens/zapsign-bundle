<?php

namespace ThomasSens\ZapsignBundle\Model;

use ThomasSens\ZapsignBundle\Constants\SignerAuthMode;

abstract class SignersAttributes
{
    /** @var string|null $redirect_link Link para redirecionamento após signatário assinar. */
    protected ?string $redirect_link;

    /** @var string|null $name Nome completo do signatário */
    protected ?string $name;

    /** @var string|null $email E-mail do signatário */
    protected ?string $email;

    /** @var string|null $phone_country Código do país do telefone do signatário (Ex: Brasil é 55) */
    protected ?string $phone_country;

    /** @var string|null $phone_number Telefone (com DDD) do signatário (Ex: 11989118800) */
    protected ?string $phone_number;

    /**
     * @var string|null $auth_mode Você pode escolher o método de autenticação do signatário.
     * Enum: "assinaturaTela", "tokenEmail", "assinaturaTela-tokenEmail", "tokenSms", "assinaturaTela-tokenSms", "certificadoDigital"
     */
    protected ?string $auth_mode;

    /** @var bool|null $lock_name Bloquear alteração do nome pelo signatário. */
    protected ?bool $lock_name;

    /** @var bool|null $lock_email Bloquear alteração do e-mail pelo signatário. */
    protected ?bool $lock_email;

    /** @var bool|null $lock_phone Bloquear alteração do telefone pelo signatário. */
    protected ?bool $lock_phone;

    /** @var string|null $qualification Qualificação para aparecer no relatório de assinaturas. Ex: valor "testemunha" irá resultar em "Assinou como testemunha" */
    protected ?string $qualification;

    /** @var string|null $external_id ID externo do signatário na sua aplicação. */
    protected ?string $external_id;

    protected ?bool $require_selfie_photo;
    protected ?bool $require_document_photo;
    protected ?string $status;
    protected ?int $times_viewed;
    protected ?string $last_view_at;
    protected ?string $signed_at;
    protected ?string $geo_latitude;
    protected ?string $geo_longitude;
    protected ?string $token;
    protected ?bool $send_automatic_email;
    protected ?string $custom_message;
    protected ?string $sign_url;

    protected ?bool $hide_email;
    protected ?bool $blank_email;
    protected ?bool $hide_phone;
    protected ?bool $blank_phone;
    protected ?string $signature_image;
    protected ?string $visto_image;
    protected ?string $document_photo_url;
    protected ?string $document_verse_photo_url;
    protected ?string $selfie_photo_url;
    protected ?string $selfie_photo_url2;
    protected ?string $send_via;
    protected ?bool $send_automatic_whatsapp_signed_file;

    /**
     * @return string|null
     */
    public function getRedirectLink(): ?string
    {
        return $this->redirect_link;
    }

    /**
     * @param string|null $redirect_link Link para redirecionamento após signatário assinar.
     * @return self
     */
    public function setRedirectLink(?string $redirect_link): self
    {
        $this->redirect_link = $redirect_link;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name Nome completo do signatário
     * @return self
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email E-mail do signatário
     * @return self
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneCountry(): ?string
    {
        return $this->phone_country;
    }

    /**
     * @param string|null $phone_country Código do país do telefone do signatário (Ex: Brasil é 55)
     * @return self
     */
    public function setPhoneCountry(?string $phone_country): self
    {
        $this->phone_country = $phone_country;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    /**
     * @param string|null $phone_number Telefone (com DDD) do signatário (Ex: 11989118800)
     * @return self
     */
    public function setPhoneNumber(?string $phone_number): self
    {
        $this->phone_number = $phone_number;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthMode(): ?string
    {
        return $this->auth_mode;
    }

    /**
     * @param string|null $auth_mode Você pode escolher o método de autenticação do signatário.
     * Enum: "assinaturaTela", "tokenEmail", "assinaturaTela-tokenEmail", "tokenSms", "assinaturaTela-tokenSms", "certificadoDigital"
     * @return self
     */
    public function setAuthMode(?string $auth_mode): self
    {
        $this->auth_mode = $auth_mode;
        //if ($auth_mode == SignerAuthMode::SCREEN_SIGN) {
        //    $this->setRequireDocumentPhoto(false);
        //} 
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getLockName(): ?bool
    {
        return $this->lock_name;
    }

    /**
     * @param bool|null $lock_name Bloquear alteração do nome pelo signatário.
     * @return self
     */
    public function setLockName(?bool $lock_name): self
    {
        $this->lock_name = $lock_name;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getLockEmail(): ?bool
    {
        return $this->lock_email;
    }

    /**
     * @param bool|null $lock_email Bloquear alteração do e-mail pelo signatário.
     * @return self
     */
    public function setLockEmail(?bool $lock_email): self
    {
        $this->lock_email = $lock_email;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getLockPhone(): ?bool
    {
        return $this->lock_phone;
    }

    /**
     * @param bool|null $lock_phone Bloquear alteração do telefone pelo signatário.
     * @return self
     */
    public function setLockPhone(?bool $lock_phone): self
    {
        $this->lock_phone = $lock_phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQualification(): ?string
    {
        return $this->qualification;
    }

    /**
     * @param string|null $qualification Qualificação para aparecer no relatório de assinaturas. Ex: valor "testemunha" irá resultar em "Assinou como testemunha"
     * @return self
     */
    public function setQualification(?string $qualification): self
    {
        $this->qualification = $qualification;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalId(): ?string
    {
        return $this->external_id;
    }

    /**
     * @param string|null $external_id ID externo do signatário na sua aplicação.
     * @return self
     */
    public function setExternalId(?string $external_id): self
    {
        $this->external_id = $external_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return int|null
     */
    public function getTimesViewed(): ?int
    {
        return $this->times_viewed;
    }

    /**
     * @return string|null
     */
    public function getLastViewAt(): ?string
    {
        return $this->last_view_at;
    }

    /**
     * @return string|null
     */
    public function getSignedAt(): ?string
    {
        return $this->signed_at;
    }

    /**
     * @return string|null
     */
    public function getGeoLatitude(): ?string
    {
        return $this->geo_latitude;
    }

    /**
     * @return string|null
     */
    public function getGeoLongitude(): ?string
    {
        return $this->geo_longitude;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

     /**
     * @param string|null
     * @return self
     */
    public function setToken(?string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function setSendAutomaticEmail(bool $send): void
    {
        $this->send_automatic_email = $send;
    }

    public function getSendAutomaticEmail(): ?bool
    {
        return $this->send_automatic_email;
    }

    public function setCustomMessage(string $custom_message): void
    {
        $this->custom_message = $custom_message;
    }

    public function getCustomMessage(): ?string
    {
        return $this->custom_message;
    }

    public function setRequireSelfiePhoto(bool $required): void
    {
        $this->require_selfie_photo = $required;
    }

    public function getRequireSelfiePhoto(): ?bool
    {
        return $this->require_selfie_photo;
    }

    public function setRequireDocumentPhoto(bool $required): void
    {
        $this->require_document_photo = $required;
    }

    public function getRequireDocumentPhoto(): ?bool
    {
        return $this->require_document_photo;
    }

    public function getSignUrl(): ?string
    {
        return $this->sign_url;
    }

    public function setSignUrl($sign_url): void
    {
        $this->sign_url = $sign_url;
    }

    public static function new(string $name, string $email): self
    {
        return (new static())
            ->setName($name)
            ->setEmail($email);
    }

    public function getHideEmail(): ?bool { return $this->hide_email; }
    public function setHideEmail(?bool $hide_email): self { $this->hide_email = $hide_email; return $this; }

    public function getBlankEmail(): ?bool { return $this->blank_email; }
    public function setBlankEmail(?bool $blank_email): self { $this->blank_email = $blank_email; return $this; }

    public function getHidePhone(): ?bool { return $this->hide_phone; }
    public function setHidePhone(?bool $hide_phone): self { $this->hide_phone = $hide_phone; return $this; }

    public function getBlankPhone(): ?bool { return $this->blank_phone; }
    public function setBlankPhone(?bool $blank_phone): self { $this->blank_phone = $blank_phone; return $this; }

    public function getSignatureImage(): ?string { return $this->signature_image; }
    public function setSignatureImage(?string $signature_image): self { $this->signature_image = $signature_image; return $this; }

    public function getVistoImage(): ?string { return $this->visto_image; }
    public function setVistoImage(?string $visto_image): self { $this->visto_image = $visto_image; return $this; }

    public function getDocumentPhotoUrl(): ?string { return $this->document_photo_url; }
    public function setDocumentPhotoUrl(?string $url): self { $this->document_photo_url = $url; return $this; }

    public function getDocumentVersePhotoUrl(): ?string { return $this->document_verse_photo_url; }
    public function setDocumentVersePhotoUrl(?string $url): self { $this->document_verse_photo_url = $url; return $this; }

    public function getSelfiePhotoUrl(): ?string { return $this->selfie_photo_url; }
    public function setSelfiePhotoUrl(?string $url): self { $this->selfie_photo_url = $url; return $this; }

    public function getSelfiePhotoUrl2(): ?string { return $this->selfie_photo_url2; }
    public function setSelfiePhotoUrl2(?string $url): self { $this->selfie_photo_url2 = $url; return $this; }

    public function getSendVia(): ?string { return $this->send_via; }
    public function setSendVia(?string $send_via): self { $this->send_via = $send_via; return $this; }

    public function getSendAutomaticWhatsappSignedFile(): ?bool { return $this->send_automatic_whatsapp_signed_file; }
    public function setSendAutomaticWhatsappSignedFile(?bool $value): self { $this->send_automatic_whatsapp_signed_file = $value; return $this; }
}