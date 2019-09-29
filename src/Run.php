<?php

namespace App\src;

class Run
{
    /**
     * Run constructor.
     * @param array $countries
     */
    public function __construct(array $countries)
    {
        //error_log(print_r($countries, true), 3, 'error.log');

        if (empty($countries)) {
            echo "No countries provided... \n";
            exit;
        }

        $restCountries = new RestCountries();
        switch (count($countries)) {
            case 1:
                try {
                    $country = $restCountries->fields(['languages'])->byName($countries[0], true);
                    \printf("Country language code: '%s'\n", $country[0]->languages[0]->iso639_1);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                break;
            case 2:
                $languages = array();
                try {
                    foreach ($countries as $country) {
                        $languages[] = $restCountries->fields(['languages'])->byName($country, true)[0]->languages[0]->iso639_1;
                    }
                    if (count(array_unique($languages)) != 1) {
                        \printf("%s and %s do not speak the same language.\n", $countries[0], $countries[1]);
                    } else {
                        \printf("%s and %s speak the same language.\n", $countries[0], $countries[1]);
                    }
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                break;
            default:
                echo "Invalid Input...\n";
                break;

        }
    }
}
