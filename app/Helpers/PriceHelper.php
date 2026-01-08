<?php

if (!function_exists('format_price')) {
    /**
     * Formate un prix en FCFA
     *
     * @param float|int $price Le prix à formater
     * @param bool $showCurrency Afficher ou non "FCFA" (par défaut true)
     * @return string Le prix formatté
     */
    function format_price($price, $showCurrency = true)
    {
        if (is_null($price)) {
            return $showCurrency ? '0 FCFA' : '0';
        }

        // Formater le nombre avec séparateur de milliers (espace)
        $formatted = number_format((float)$price, 0, ',', ' ');

        return $showCurrency ? $formatted . ' FCFA' : $formatted;
    }
}

if (!function_exists('fcfa')) {
    /**
     * Alias court pour format_price
     *
     * @param float|int $price Le prix à formater
     * @return string Le prix formatté en FCFA
     */
    function fcfa($price)
    {
        return format_price($price, true);
    }
}
