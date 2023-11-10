<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Model;

use IteratorAggregate;

/**
 * @extends IteratorAggregate<DocumentInterface>
 */
interface DocumentsInterface extends IteratorAggregate
{
    public function addDocument(DocumentInterface $document): self;

    /** @return DocumentInterface[] */
    public function getDocuments(): array;

    public function isFinished(): bool;

    public function setFinished(bool $finished): self;
}
