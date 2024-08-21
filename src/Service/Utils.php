<?php
namespace ThomasSens\ZapsignBundle\Service;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;
use ThomasSens\ZapsignBundle\Model\Document;
use ThomasSens\ZapsignBundle\Model\Signer;

class Utils
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Converts the response data to an instance of the specified class.
     *
     * @param StreamInterface $responseData
     * @param string $class The fully qualified class name of the target object.
     * @return object|null An instance of the specified class or null on failure.
     */
    public function convertToClass(StreamInterface $responseData, string $class): ?object
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        // Read the response data as string
        $responseDataString = $responseData->getContents();
        // Deserialize the JSON to the specified class
        return $serializer->deserialize($responseDataString, $class, 'json');
    }

    public function convertArraYToClass(array $data, string $class): ?object
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        // Read the response data as string
        $responseDataString = json_encode($data);
        // Deserialize the JSON to the specified class
        return $serializer->deserialize($responseDataString, $class, 'json');
    }

    /**
     * Trata a resposta da API e loga informações relevantes.
     *
     * @param ResponseInterface $response A resposta da API.
     * @param string $metodo O nome do método ou operação relacionada à resposta.
     */
    public function trataResposta(ResponseInterface $response, string $metodo): void
    {
        $this->logger->info("Método: $metodo");
        
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        
        // Verifica se o corpo da resposta não está vazio
        if (!empty($body)) {
            $errorData = json_decode($body, true);
            
            // Verifica se a decodificação JSON foi bem-sucedida
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->logger->info("Retornou um status diferente do esperado: $statusCode");
                $this->logger->info("Error Response Body: " . json_encode($errorData, JSON_PRETTY_PRINT));
            } else {
                $this->logger->error("Erro ao decodificar JSON: " . json_last_error_msg());
                $this->logger->info("Resposta não pode ser processada como JSON: " . $body);
            }
        } else {
            $this->logger->info("Resposta vazia recebida com status code: $statusCode");
        }
    }

    /**
     * Converte um objeto Document para um array com chaves em snake_case.
     *
     * @param Document $doc O documento a ser convertido.
     * @return array|null O array convertido com chaves em snake_case ou null em caso de falha.
     */
    public function documentToArray(Document $doc): ?array
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $json = $serializer->serialize($doc, 'json');
        $data = json_decode($json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Handle JSON error
            return null;
        }

        return $this->arrayKeysToSnakeCase($data);
    }

    /**
     * Converte um objeto Signer para um array com chaves em snake_case.
     *
     * @param Signer $signer O signer a ser convertido.
     * @return array|null O array convertido com chaves em snake_case ou null em caso de falha.
     */
    public function signerToArray(Signer $signer): ?array
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $json = $serializer->serialize($signer, 'json');
        $data = json_decode($json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Handle JSON error
            return null;
        }

        return $this->arrayKeysToSnakeCase($data);
    }

    /**
     * Converte as chaves de um array para snake_case.
     *
     * @param array $array O array cujas chaves serão convertidas.
     * @return array O array com as chaves convertidas para snake_case.
     */
    public function arrayKeysToSnakeCase(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_null($key) || $key === '') {
                continue; // Skip null or empty keys
            }

            $snakeKey = $this->camelToSnakeCase($key);

            if (is_array($value)) {
                $result[$snakeKey] = $this->arrayKeysToSnakeCase($value);
            } else {
                $result[$snakeKey] = $value;
            }
        }

        return $result;
    }

    /**
     * Converte uma string camelCase para snake_case.
     *
     * @param string $input A string em camelCase.
     * @return string A string convertida para snake_case.
     */
    private function camelToSnakeCase(string $input): string
    {
        if (ctype_lower($input)) {
            return $input; // Early return if already snake_case
        }

        $output = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
        return $output;
    }
}