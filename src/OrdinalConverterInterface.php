<?php

namespace OrdinalTextConverter;

interface OrdinalConverterInterface
{
    public function toWords(int $num, string $locale, array $options): string;
    public function toOrdinalNumbers(int $number, string $locale): string;
}