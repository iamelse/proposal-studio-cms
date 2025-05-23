<?php

use Mews\Purifier\Facades\Purifier;

if (!function_exists('cleanHtmlFields')) {
    /**
     * Clean multiple fields with different purifier rules.
     *
     * @param array $content  The array of fields to clean
     * @param array $rules    Associative array with field names as keys and purifier rules as values
     * @return array          Cleaned content
     */
    function cleanHtmlFields(array $content, array $rules): array
    {
        foreach ($rules as $field => $purifierRules) {
            if (isset($content[$field])) {
                $content[$field] = Purifier::clean($content[$field], $purifierRules);
            }
        }
        return $content;
    }
}
