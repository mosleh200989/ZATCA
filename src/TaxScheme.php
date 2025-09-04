<?php

namespace Saleh7\Zatca;

use InvalidArgumentException;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

/**
 * Class TaxScheme
 *
 * Represents a tax scheme with its identifier, tax type code, and name.
 */
class TaxScheme implements XmlSerializable
{
    /** @var string|null Tax scheme identifier. */
    private ?string $id = null;

    /** @var string|null Tax type code. */
    private ?string $taxTypeCode = null;

    /** @var string|null Name of the tax scheme. */
    private ?string $name = null;

    /**
     * Set the tax scheme identifier.
     *
     * @throws InvalidArgumentException if ID is empty.
     */
    public function setId(string $id): self
    {
        if (trim($id) === '') {
            throw new InvalidArgumentException('Tax scheme ID cannot be empty.');
        }
        $this->id = $id;

        return $this;
    }

    /**
     * Get the tax scheme identifier.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set the tax type code.
     */
    public function setTaxTypeCode(?string $taxTypeCode): self
    {
        $this->taxTypeCode = $taxTypeCode;

        return $this;
    }

    /**
     * Set the name of the tax scheme.
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Serializes this object to XML.
     *
     * @param  Writer  $writer  The XML writer.
     */
    public function xmlSerialize(Writer $writer): void
    {
        if ($this->id !== null) {
            $writer->write([Schema::CBC.'ID' => $this->id]);
        }
        if ($this->taxTypeCode !== null) {
            $writer->write([
                Schema::CBC.'TaxTypeCode' => $this->taxTypeCode,
            ]);
        }
        if ($this->name !== null) {
            $writer->write([
                Schema::CBC.'Name' => $this->name,
            ]);
        }
    }
}
