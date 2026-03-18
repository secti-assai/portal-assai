<?php

declare(strict_types=1);

namespace App\Support\Concerns;

trait NormalizesSearch
{
    protected function normalizedColumnSql(string $column): string
    {
        return "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE({$column}, 'á', 'a'), 'à', 'a'), 'â', 'a'), 'ã', 'a'), 'ä', 'a'), 'é', 'e'), 'ê', 'e'), 'è', 'e'), 'ë', 'e'), 'í', 'i'), 'ì', 'i'), 'ï', 'i'), 'ó', 'o'), 'ô', 'o'), 'õ', 'o'), 'ò', 'o'), 'ö', 'o'), 'ú', 'u'), 'ù', 'u'), 'ü', 'u'), 'ç', 'c'), 'ñ', 'n'), 'ý', 'y'))";
    }

    protected function normalizeSearchTerm(string $term): string
    {
        $normalized = mb_strtolower($term, 'UTF-8');

        return strtr($normalized, [
            'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'é' => 'e', 'ê' => 'e', 'è' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ò' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n', 'ý' => 'y',
        ]);
    }
}
