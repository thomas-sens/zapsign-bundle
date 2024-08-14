<?php

namespace ThomasSens\ZapsignBundle\Model;

abstract class DocumentAttributes extends BaseDocument
{
    /** @var bool|null $sandbox Defina como true caso se trate de um documento de teste */
    protected ?bool $sandbox;

    /** @var Signer[]|null $signers Representa os signatários do documento */
    protected ?array $signers;

    public function __construct()
    {
        $this->sandbox = true;
    }

    /**
     * @return bool|null
     */
    public function getSandbox(): ?bool
    {
        return $this->sandbox;
    }

    /**
     * @return Signer[]|null
     */
    public function getSigners(): ?array
    {
        return $this->signers;
    }

    /**
     * @param Signer[]|null $signers Representa os signatários do documento
     * @return self
     */
    public function setSigners(?array $signers): self
    {
        $this->signers = $signers;
        return $this;
    }

    /**
     * @param string $name Nome do documento. Máximo 255 caracteres
     * @param string $urlPdf URL pública do PDF. Máximo 10Mb
     * @param Signer[] $signers Representa os signatários do documento
     * @return static
     */
    public function new(string $name, int $externalId, string $urlPdf, array $signers): self
    {
        return  $this
            ->setName($name)
            ->setExternalId($externalId)
            //->setUrlPdf($urlPdf)
            ->setBase64Pdf($this->convert($urlPdf))
            ->setSigners($signers);
    }

    public function convert(string $filePath): ?string
    {
        // Verifica se o arquivo existe
        if (!file_exists($filePath)) {
            throw new \Exception("O arquivo não foi encontrado: " . $filePath);
        }

        // Lê o conteúdo do arquivo
        $fileContent = file_get_contents($filePath);
        if ($fileContent === false) {
            throw new \Exception("Erro ao ler o arquivo: " . $filePath);
        }

        // Converte o conteúdo para Base64
        $base64String = base64_encode($fileContent);

        return $base64String;
    }
}