<?php

declare(strict_types=1);

namespace App\Services;

class TextNormalizer
{
    /**
     * Normalizar texto removendo acentos e convertendo para minúsculas
     */
    public static function normalize(string $texto): string
    {
        // Converter para minúsculas
        $texto = mb_strtolower($texto, 'UTF-8');

        // Remover acentos usando transliteração
        $texto = self::removerAcentos($texto);

        // Remover caracteres especiais mantendo apenas letras, números e espaços
        $texto = preg_replace('/[^a-z0-9\s]/u', '', $texto);

        // Remover espaços múltiplos
        $texto = trim(preg_replace('/\s+/', ' ', $texto));

        return $texto;
    }

    /**
     * Remover acentos de uma string
     */
    private static function removerAcentos(string $texto): string
    {
        $acentos = [
            'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n',
            'Á' => 'a', 'À' => 'a', 'Ã' => 'a', 'Â' => 'a', 'Ä' => 'a',
            'É' => 'e', 'È' => 'e', 'Ê' => 'e', 'Ë' => 'e',
            'Í' => 'i', 'Ì' => 'i', 'Î' => 'i', 'Ï' => 'i',
            'Ó' => 'o', 'Ò' => 'o', 'Õ' => 'o', 'Ô' => 'o', 'Ö' => 'o',
            'Ú' => 'u', 'Ù' => 'u', 'Û' => 'u', 'Ü' => 'u',
            'Ç' => 'c', 'Ñ' => 'n',
        ];

        return strtr($texto, $acentos);
    }

    /**
     * Tokenizar texto em palavras individuais
     */
    public static function tokenize(string $texto): array
    {
        $tokens = preg_split('/\s+/', trim($texto), -1, PREG_SPLIT_NO_EMPTY);
        return array_filter($tokens ?: []);
    }

    /**
     * Remover stopwords comuns em português
     */
    public static function removeStopwords(array $tokens): array
    {
        $stopwords = [
            'o', 'a', 'os', 'as',
            'um', 'uma', 'uns', 'umas',
            'de', 'do', 'da', 'dos', 'das',
            'e', 'ou', 'mas',
            'em', 'para', 'com', 'por', 'sem',
            'que', 'qual', 'quais',
            'é', 'são', 'era', 'eram',
            'ser', 'estar', 'ter', 'ir',
            'este', 'esse', 'aquele',
            'eu', 'tu', 'ele', 'nós', 'vós', 'eles',
            'meu', 'teu', 'seu', 'nosso', 'vosso',
            'não', 'sim', 'talvez',
            'aqui', 'aí', 'ali',
            'me', 'te', 'lhe', 'nos', 'vos',
            'mi', 'ti', 'si',
        ];

        return array_filter($tokens, fn($token) => !in_array($token, $stopwords));
    }

    /**
     * Extrair tokens do conteúdo (contexto) com ponderação
     * Tokens mais frequentes no conteúdo recebem scores mais altos
     * Retorna array com token => frequência
     */
    public static function extrairTokensConteudo(string $conteudo): array
    {
        $tokens = self::tokenize($conteudo);
        $tokens = self::removeStopwords($tokens);

        // Contar frequência de cada token
        $frequencias = [];
        foreach ($tokens as $token) {
            if (strlen($token) > 2) { // Ignorar tokens muito curtos
                $frequencias[$token] = ($frequencias[$token] ?? 0) + 1;
            }
        }

        return $frequencias;
    }
}
