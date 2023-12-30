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
     * The word for the minus sign
     * @var string
     * @access private
     */
    private string $_minus = 'negativo';

    /**
     * The word separator for numerals
     * @var string
     * @access private
     */
    private string $_sep = ' ';

    private array $_contractions = [
        '',
        'DÉCIMA PRIMEIRA',
        'DÉCIMA SEGUNDA',
        'DÉCIMA TERCEIRA',
        'DÉCIMA QUARTA',
        'DÉCIMA QUINTA',
        'DÉCIMA SEXTA',
        'DÉCIMA SÉTIMA',
        'DÉCIMA OITAVA',
        'DÉCIMA NONA'
    ];

    private array $_words = [
        // Os ordinais para os dígitos
        ['', 'PRIMEIRA', 'SEGUNDA', 'TERCEIRA', 'QUARTA', 'QUINTA', 'SEXTA', 'SÉTIMA', 'OITAVA', 'NONA'],

        // Os ordinais para os múltiplos de 10
        ['', 'DÉCIMA', 'VIGÉSIMA', 'TRIGÉSIMA', 'QUADragésima', 'QUINQUAGÉSIMA', 'SEXAGÉSIMA', 'SEPTUAGÉSIMA', 'OCTOGÉSIMA', 'NONAGÉSIMA'],

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
    function _toWords(int $num): string
    {
        $neg   = 0;
        $ret   = [];

        if ($num < 0) {
            $ret[] = $this->_minus;
            $num   = -$num;
            $neg   = 1;
        }

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

        if ((count($ret) > 2 + $neg) && $this->_mustSeparate($chunks)) {
            $ret[1 + $neg] = trim($this->_sep . $ret[1 + $neg]);
        }

        $ret = array_reverse(array_filter($ret));

        return implode(' ', $ret);
    }

    function _parseChunk(string $chunk): array
    {

        if (!$chunk) {
            return [];
        }

        if (($chunk < 20) && ($chunk > 10)) {
            return array($this->_contractions[$chunk % 10]);
        }

        $i    = strlen($chunk)-1;
        $n    = (int)$chunk[0];
        $word = $this->_words[$i][$n];

        return array_merge(array($word), $this->_parseChunk(substr($chunk, 1)));
    }

    function _mustSeparate(array $chunks): bool
    {
        $chunk = null;

        reset($chunks);
        do {
            list(,$chunk) = each($chunks);
        } while ($chunk === '000');

        if (($chunk < 100) || !($chunk % 100)) {
            return true;
        }
        return false;
    }
}