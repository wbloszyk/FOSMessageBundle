<?php

namespace FOS\MessageBundle\Search;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Gets the search term from the request and prepares it.
 */
class QueryFactory implements QueryFactoryInterface
{
    protected RequestStack $request;

    /**
     * The query parameter containing the search term.
     */
    protected string $queryParameter;

    /**
     * Instanciates a new TermGetter.
     */
    public function __construct(RequestStack $requestStack, string $queryParameter)
    {
        $this->request = $requestStack;
        $this->queryParameter = $queryParameter;
    }

    public function createFromRequest(): Query
    {
        $original = $this->getCurrentRequest()->query->get($this->queryParameter);
        $original = trim($original);

        $escaped = $this->escapeTerm($original);

        return new Query($original, $escaped);
    }

    /**
     * Sets: the query parameter containing the search term.
     */
    public function setQueryParameter(string $queryParameter): void
    {
        $this->queryParameter = $queryParameter;
    }

    protected function escapeTerm($term): string
    {
        return $term;
    }

    /**
     * BC layer to retrieve the current request directly or from a stack.
     */
    private function getCurrentRequest(): ?Request
    {
        return $this->request->getCurrentRequest();
    }
}
