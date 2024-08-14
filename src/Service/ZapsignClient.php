<?php

namespace ThomasSens\ZapsignBundle\Service;

use GuzzleHttp\Client as GClient;
use GuzzleHttp\Exception\RequestException;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use ThomasSens\ZapsignBundle\Model\Document;
use ThomasSens\ZapsignBundle\Model\DocumentList;
use ThomasSens\ZapsignBundle\Model\Signer;
use ThomasSens\ZapsignBundle\Service\Utils;

class ZapsignClient
{
    private $api_url;
    private $api_token;
    private $logger;
    private $client;
    private $utils;

    public function __construct(ParameterBagInterface $parameter, LoggerInterface $logger, Utils $utils)
    {
        $this->logger = $logger;
        $this->utils = $utils;
        $this->api_url = $parameter->get('zapsign.api_url');
        $this->api_token = $parameter->get('zapsign.api_token');
        $this->client = new GClient(['verify' => false]);
    }

    /**
     * Lista todos os documentos.
     *
     * @return DocumentList|null
     */
    public function listDocuments(): ?DocumentList
    {
        $url = $this->api_url . '/api/v1/docs/?api_token=' . $this->api_token;
        return $this->makeRequest('GET', $url, null, DocumentList::class);
    }

    /**
     * Cria um documento a partir do upload.
     *
     * @param Document $doc O documento a ser criado.
     * @return Document|null
     */
    public function createDocFromUpload(Document $doc): ?Document
    {
        $url = $this->api_url . '/api/v1/docs/?api_token=' . $this->api_token;
        $data = $this->utils->documentToArray($doc);

        dump($data);
        $document = $this->makeRequest('POST', $url, $data, Document::class);
        dd($document);
        $arrSigners = [];
        foreach ($document->getSigners() as $signer) {
            array_push($arrSigners,$this->utils->convertArraYToClass($signer, Signer::class));
        }
        $document->setSigners($arrSigners);
        return $document;
    }

    /**
     * Faz uma requisição HTTP e trata a resposta.
     *
     * @param string $method O método HTTP (GET, POST, etc.).
     * @param string $url O URL da requisição.
     * @param array|null $data Dados a serem enviados no corpo da requisição (para métodos POST).
     * @return mixed|null O resultado da deserialização ou null em caso de falha.
     */
    private function makeRequest(string $method, string $url, array $data = null, string $class)
    {
        try {
            $options = [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]
            ];

            if ($data !== null) {
                $options['json'] = $data;
            }

            $response = $this->client->request($method, $url, $options);
            $statusCode = $response->getStatusCode();
            dump($statusCode);
            dump($response->getBody());
            if ($statusCode === 200) {
                return $this->utils->convertToCLass($response->getBody(), $class);
            }

            $this->utils->trataResposta($response, $method);
        } catch (RequestException $e) {
            $this->logger->error("Erro na requisição: " . $e->getMessage());
            if ($e->hasResponse()) {
                $this->utils->trataResposta($e->getResponse(), $method);
            }
        }

        return null;
    }

}