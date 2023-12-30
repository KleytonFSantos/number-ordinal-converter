# OrdinalTextConverter

    Simples conversor de inteiros para strings ordinais por extenso.

## Como instalar

```text
composer require kleytondev/number-ordinal-converter
```

## Como utilizar

Para utilizar, siga o exemplo abaixo:

```php
$ordinalConverter = new \OrdinalTextConverter\OrdinalConverter();

echo $ordinalConverter->toWords(20);
```

## Requisitos 

- PHP 7.4 ou superior