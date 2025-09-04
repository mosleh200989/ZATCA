<?php

namespace Mosleh200989\ZATCA\Tests;

use PHPUnit\Framework\TestCase;
use Mosleh200989\ZATCA\Helpers\QRCodeGenerator;
use Mosleh200989\ZATCA\Tags\CertificateSignature;
use Mosleh200989\ZATCA\Tags\InvoiceDate;
use Mosleh200989\ZATCA\Tags\InvoiceDigitalSignature;
use Mosleh200989\ZATCA\Tags\InvoiceHash;
use Mosleh200989\ZATCA\Tags\InvoiceTaxAmount;
use Mosleh200989\ZATCA\Tags\InvoiceTotalAmount;
use Mosleh200989\ZATCA\Tags\PublicKey;
use Mosleh200989\ZATCA\Tags\Seller;
use Mosleh200989\ZATCA\Tags\TaxNumber;

/**
 * Test class for the QRCodeGenerator.
 */
class QRCodeGeneratorTest extends TestCase
{
    /**
     * Test that encodeTLV() returns the correct TLV string.
     *
     * This test creates a few Tag instances, builds the expected TLV
     * string by concatenating each tag's __toString() output, and then
     * compares it to the generator's output.
     */
    public function test_encode_tlv()
    {
        // Create sample tags.
        $seller = new Seller('latency.sa');
        $taxNumber = new TaxNumber('311111111111113');

        // Build the expected TLV string.
        $expectedTLV = (string) $seller.(string) $taxNumber;

        // Create the generator with the sample tags.
        $generator = QRCodeGenerator::createFromTags([$seller, $taxNumber]);

        // Assert that the TLV encoding matches the expected string.
        $this->assertEquals($expectedTLV, $generator->encodeTLV(), 'TLV encoding does not match the expected value.');
    }

    /**
     * Test that encodeBase64() returns the correct Base64 encoded TLV string.
     *
     * This test creates a list of Tag instances, builds the TLV string from
     * each tag, encodes it with Base64, and then compares it to the generator's output.
     */
    public function test_encode_base64()
    {
        // Create sample tags.
        $tags = [
            new Seller('latency.sa'),
            new TaxNumber('311111111111113'),
            new InvoiceDate('2025-02-12T14:25:09Z'),
            new InvoiceTotalAmount('100.00'),
            new InvoiceTaxAmount('15.00'),
            new InvoiceHash('EBjEwMC4wMAUFMTUuMDA='),
            new InvoiceDigitalSignature('EBjEwMC4wMAUFMTUuMDA='),
            new PublicKey('EBjEwMC4wMAUFMTUuMDA='),
            new CertificateSignature('EBjEwMC4wMAUFMTUuMDA='),
        ];

        // Build the expected TLV string.
        $expectedTLV = '';
        foreach ($tags as $tag) {
            $expectedTLV .= (string) $tag;
        }
        // Encode the TLV string into Base64.
        $expectedBase64 = base64_encode($expectedTLV);

        // Create the generator with the sample tags.
        $generator = QRCodeGenerator::createFromTags($tags);

        // Assert that the Base64 encoded TLV string matches the expected value.
        $this->assertEquals($expectedBase64, $generator->encodeBase64(), 'Base64 encoded TLV string does not match the expected value.');
    }

    /**
     * Test that creating a QRCodeGenerator with no valid tags throws an exception.
     *
     * This test verifies that if an empty array is passed to the generator,
     * an InvalidArgumentException is thrown.
     */
    public function test_empty_tags_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Malformed data structure: no valid Tag instances found.');

        // Attempt to create the generator with an empty array.
        QRCodeGenerator::createFromTags([]);
    }
}
