<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Traversable;

class Documents implements DocumentsInterface
{
    /** @var DocumentInterface[] */
    private array $documents = [];

    private bool $finished = false;

    public function addDocument(DocumentInterface $document): DocumentsInterface
    {
        $this->documents[] = $document;

        return $this;
    }

    public function getDocuments(): array
    {
        return $this->documents;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): self
    {
        $this->finished = $finished;

        return $this;
    }

    public function getIterator(): Traversable
    {
        return new ArrayCollection($this->documents);
    }
}
