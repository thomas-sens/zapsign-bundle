<?php

namespace ThomasSens\ZapsignBundle\Tests\Service;

use GuzzleHttp\Client as GClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use ThomasSens\ZapsignBundle\Model\Document;
use ThomasSens\ZapsignBundle\Model\DocumentList;
use ThomasSens\ZapsignBundle\Service\Utils;
use ThomasSens\ZapsignBundle\Service\ZapsignClient;

class ZapsignClientTest extends TestCase
{
    private $parameterBag;
    private $logger;
    private $utils;
    private $httpClient;
    private $zapsignClient;

    protected function setUp(): void
    {
        $this->parameterBag = $this->createMock(ParameterBagInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->utils = $this->createMock(Utils::class);
        $this->httpClient = $this->createMock(GClient::class);

        $this->parameterBag->method('get')->willReturnMap([
            ['zapsign.api_url', 'https://api.zapsign.com.br'],
            ['zapsign.api_token', 'fake_token'],
        ]);

        $this->zapsignClient = new ZapsignClient($this->parameterBag, $this->logger, $this->utils);
    }

    public function testListDocuments()
    {
        $response = new Response(200, [], json_encode(['documents' => []]));
        
        $this->httpClient->method('request')->willReturn($response);
        $this->utils->method('convertToCLass')->willReturn(new DocumentList());
        
        $result = $this->zapsignClient->listDocuments();
        
        $this->assertInstanceOf(DocumentList::class, $result);
    }

    public function testCreateDocFromUpload()
    {
        $document = $this->createMock(Document::class);
        $response = new Response(200, [], json_encode([]));
        
        $this->httpClient->method('request')->willReturn($response);
        $this->utils->method('convertToCLass')->willReturn($document);
        
        $result = $this->zapsignClient->createDocFromUpload($document);
        
        $this->assertInstanceOf(Document::class, $result);
    }

    public function testGetDetailDoc()
    {
        $document = $this->createMock(Document::class);
        $response = new Response(200, [], json_encode([]));
        
        $this->httpClient->method('request')->willReturn($response);
        $this->utils->method('convertToCLass')->willReturn($document);
        
        $result = $this->zapsignClient->getDetailDoc('12345');
        
        $this->assertInstanceOf(Document::class, $result);
    }
}
