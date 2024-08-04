# ZapsignBundle
Zapsign integration for Symfony

Instalation:
```
composer require thomas-sens/zapsign-bundle 
```

Generate a parameters file:
```
php bin/console config:dump-reference ZapsignBundle > config/packages/zapsign.yaml
```

Example: src/config/packages/zapsign.yaml
```
zapsign:
    api_url: 'https://sandbox.api.zapsign.com.br'
    api_token: bf0dae0f-94e4-4f0e-9515-85c8b085a7d39ffd7954-77ac-466f-ae3c-ccfc41e9b4d3
```

Call Example:
```
class ZapsignController extends AbstractController
{
    #[Route('/zapsign', name: 'app_zapsign')]
    public function index(ZapsignClient $zapsign): Response
    {
        $signer1 = new Signer();
        $signer1->setName("Thomas");
        $signer2 = new Signer();
        $signer2->setName("Letícia");
        $signers = array($signer1,$signer2);
        $doc = new Document();
        $doc->new("Documento teste","https://zapsign.s3.amazonaws.com/2022/1/pdf/63d19807-cbfa-4b51-8571-215ad0f4eb98/ca42e7be-c932-482c-b70b-92ad7aea04be.pdf", $signers);
        
        dump($zapsign->createDocFromUpload($doc));
        dump($zapsign->listDocuments());
        dd('fim');
    }
}
```