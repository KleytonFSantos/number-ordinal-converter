<?php declare(strict_types=1);

use OrdinalTextConverter\OrdinalTextException;
use PHPUnit\Framework\TestCase;
use OrdinalTextConverter\OrdinalConverter;

class OrdinalTest extends TestCase {

    /** @test
     * @throws OrdinalTextException
     */
    public function it_will_return_ordinated_number_in_string()
    {
        $ordinalTest = new OrdinalConverter();

        $this->assertEquals('CENTÉSIMA PRIMEIRA', $ordinalTest->toWords(101));
    }
}