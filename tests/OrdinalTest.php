<?php declare(strict_types=1);

use OrdinalTextConverter\OrdinalTextException;
use PHPUnit\Framework\TestCase;
use OrdinalTextConverter\OrdinalConverter;

class OrdinalTest extends TestCase {

    /** @test
     * @throws OrdinalTextException
     */
    public function it_will_return_ordinated_number_in_string(): void
    {
        $ordinalTest = new OrdinalConverter();

        $this->assertEquals('CENTÉSIMA PRIMEIRA', $ordinalTest->toWords(101));
    }

    /**
     * @throws OrdinalTextException
     */
    public function test_will_throw_exception_if_calls_a_no_configured_locale(): void
    {
        $ordinalTest = new OrdinalConverter();

        $this->expectException(OrdinalTextException::class);

        $ordinalTest->toWords(101, 'en-US');
    }
}