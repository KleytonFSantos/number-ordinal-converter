<?php

namespace OrdinalTextConverter\Locale\pt;

use OrdinalTextConverter\OrdinalConverter;
use OrdinalTextConverter\OrdinalTextException;

class OrdinalTextInPtBR extends OrdinalConverter
{

    /**
     * Locale name
     * @var string
     */
    public string $locale = 'pt_BR';

    /**
     * Language name in English
     * @var string
     */
    public string $lang = 'Brazilian Portuguese';

    /**
     * Native language name
     * @var string
     */
    public string $lang_native = 'Português Brasileiro';

    /**
     * The word separator for numerals
     * @var string
     * @access private
     */
    private string $_sep = ' ';

    private array $_words = [
        // Os ordinais para os dígitos
        ['', 'PRIMEIRA', 'SEGUNDA', 'TERCEIRA', 'QUARTA', 'QUINTA', 'SEXTA', 'SÉTIMA', 'OITAVA', 'NONA'],

        // Os ordinais para os múltiplos de 10
        ['', 'DÉCIMA', 'VIGÉSIMA', 'TRIGÉSIMA', 'QUADRAGÉSIMA', 'QUINQUAGÉSIMA', 'SEXAGÉSIMA', 'SEPTUAGÉSIMA', 'OCTOGÉSIMA', 'NONAGÉSIMA'],

        // Os ordinais para as centenas
        ['', 'CENTÉSIMA', 'DUCENTÉSIMA', 'TRECENTÉSIMA', 'QUADRIGENTÉSIMA', 'QUINGENTÉSIMA', 'SEISCENTÉSIMA', 'SEPTINGENTÉSIMA', 'OCTINGENTÉSIMA', 'NONINGENTÉSIMA'],
    ];

    private array $_exponent = [
        '',         // 0: not displayed
        'MILÉSIMA',
        'MILIONÉSIMA',
        'BILIONÉSIMA',
        'TRILIONÉSIMA',
        'QUADRILIONÉSIMA',
        'QUINTILIONÉSIMA',
        'SEXTILIONÉSIMA',
        'SEPTILIONÉSIMA',
        'OCTILIONÉSIMA',
        'NONILIONÉSIMA',
        'DECILIONÉSIMA',
        'UNDÉCILIONÉSIMA',
        'DODÉCILIONÉSIMA',
        'TREDECILIONÉSIMA',
        'QUATUORDECILIONÉSIMA',
        'QUINDECILIONÉSIMA',
        'SEDECILIONÉSIMA',
        'SEPTENDCILIONÉSIMA'
    ];

    /**
     * @throws OrdinalTextException
     */
    public function _toWords(int $num): string
    {
        $ret   = [];

        $num = number_format($num, 0, '.', '.');

        if ($num == 0) {
            return 'zero';
        }

        $chunks = array_reverse(explode(".", $num));

        foreach ($chunks as $index => $chunk) {
            if (!array_key_exists($index, $this->_exponent)) {
                throw new OrdinalTextException('Number out of range.');
            }

            if ($chunk == 0) {
                continue;
            }

            $ret[] = $this->_exponent[$index];

            $word = array_filter($this->_parseChunk($chunk));
            $ret[] = implode($this->_sep, $word);
        }

        $ret = array_reverse(array_filter($ret));

        return implode(' ', $ret);
    }

    private function _parseChunk(string $chunk): array
    {
        $result = [];

        if (!$chunk) {
            return [];
        }

        $i    = strlen($chunk)-1;
        $n    = (int)$chunk[0];
        $result[] = $this->_words[$i][$n];

        return array_merge($result, $this->_parseChunk(substr($chunk, 1)));
    }
}