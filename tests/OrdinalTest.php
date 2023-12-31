<?php declare(strict_types=1);

use OrdinalTextConverter\OrdinalConverter;
use OrdinalTextConverter\OrdinalTextException;
use PHPUnit\Framework\TestCase;
use OrdinalTextConverter\OrdinalConverterInterface;

class OrdinalTest extends TestCase {

    private OrdinalConverterInterface $ordinalConverter;

    protected function setUp(
    ) {
        $this->ordinalConverter = new OrdinalConverter();
    }

    /**
     * @test
     * @throws OrdinalTextException
     */
    public function it_will_return_ordinated_number_in_string(): void
    {
        $this->assertEquals('DÉCIMA SEGUNDA', $this->ordinalConverter->toWords(12));
    }

    /**
     * @throws OrdinalTextException
     */
    public function test_will_throw_exception_if_calls_a_no_configured_locale(): void
    {
        $this->expectException(OrdinalTextException::class);
        $this->ordinalConverter->toWords(11, 'en-US');
    }

    public function test_will_return_ordinal_number_from_int(): void
    {
        $this->assertEquals('11º',  $this->ordinalConverter->toOrdinalNumbers(11, 'pt-BR'));
    }
}