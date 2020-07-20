<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input) : string
    {

        $array = [
            'à' => 'a',
            'é' => 'e',
            'è' => 'e',
            'ê' => 'e',
            'ù' => 'u',
            'ç' => 'c',
            '&' => '',
            ',' => '',
            ';' => '',
            ':' => '',
            '!' => '',
            '\(' => '',
            '\?' => '',
            '\)' => '',
            '\[' => '',
            '\]' => '',
            '\#' => '',
            '§' => '',
            '£' => '',
            '{' => '',
            '}' => '',
            '@' => '',
            '\=' => '',
            '\+' => '',
            '\-' => '',
            '\%' => ''

        ];

        $input = strtolower($input);

        foreach ($array as $key => $value){
            $input = preg_replace("/$key/", "/$value/", $input);
            $input = preg_replace('/\//', '', $input);
        }
        $input = str_replace(' ', '-', $input);

        return $input;
    }
}