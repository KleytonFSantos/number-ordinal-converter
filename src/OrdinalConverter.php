<?php
namespace OrdinalTextConverter;

/**
 * @Ordinal
 */
class OrdinalConverter implements OrdinalConverterInterface
{
    /**
     * Default Locale name
     * @var string
     * @access public
     */
    public string $locale = 'pt-BR';


    /**
     * @throws OrdinalTextException
     */
    public function toWords(int $num, string $locale = '', array $options = []): string
    {
        if (empty($locale) && isset($this)) {
            $locale = $this->locale;
        }

        $classname = self::loadLocale($locale, '_toWords');

        $obj = new $classname;

        if (empty($options)) {
            return trim($obj->_toWords($num));
        }

        return trim($obj->_toWords($num, $options));
    }

    /**
     * @throws OrdinalTextException
     */
    private static function loadLocale(string $locale, string $requiredMethod): string
    {
        $classname = 'OrdinalTextConverter\Locale\\'
            . substr($locale, 0, 2)
            . '\OrdinalTextIn' . ucwords(str_replace('-', '', $locale));

        if (!class_exists($classname)) {
            $file = str_replace('_', '/', $classname) . '.php';
            if (stream_resolve_include_path($file)) {
                include_once $file;
            }

            if (!class_exists($classname)) {
                throw new OrdinalTextException(
                    'Unable to load locale class ' . $classname
                );
            }
        }

        $methods = get_class_methods($classname);

        if (!in_array($requiredMethod, $methods)) {
            throw new OrdinalTextException(
                "Unable to find method '$requiredMethod' in class '$classname'"
            );
        }

        return $classname;
    }

    public function toOrdinalNumbers(int $number, string $locale = ''): string
    {
        $numberFormatter = new \NumberFormatter($locale,\NumberFormatter::ORDINAL);
        return $numberFormatter->format($number);
    }
}