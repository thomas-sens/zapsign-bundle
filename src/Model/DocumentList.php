<?php
namespace ThomasSens\ZapsignBundle\Model;

class DocumentList
{
    protected ?int $count;
    protected ?string $next;
    protected ?string $previous;
    
    /** 
     * @var Document[]|null $results Representa os documentos da lista 
     */
    protected ?array $results;

    public function __construct(?int $count = null, ?string $next = null, ?string $previous = null, ?array $results = null)
    {
        $this->count = $count;
        $this->next = $next;
        $this->previous = $previous;
        $this->results = $results;
    }

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @param int|null $count
     */
    public function setCount(?int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return string|null
     */
    public function getNext(): ?string
    {
        return $this->next;
    }

    /**
     * @param string|null $next
     */
    public function setNext(?string $next): void
    {
        $this->next = $next;
    }

    /**
     * @return string|null
     */
    public function getPrevious(): ?string
    {
        return $this->previous;
    }

    /**
     * @param string|null $previous
     */
    public function setPrevious(?string $previous): void
    {
        $this->previous = $previous;
    }

    /**
     * @return Document[]|null
     */
    public function getResults(): ?array
    {
        return $this->results;
    }

    /**
     * @param Document[]|null $results
     */
    public function setResults(?array $results): void
    {
        $this->results = $results;
    }

    /**
     * Add a Document to the results list.
     *
     * @param Document $document
     */
    public function addDocument(Document $document): void
    {
        if ($this->results === null) {
            $this->results = [];
        }

        $this->results[] = $document;
    }
}