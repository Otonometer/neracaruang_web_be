<?php

namespace App\Enums;

use illuminate\Support\Str;

enum SubjectTypes :int
{
    case TOKOH = 1;
    case TOPIK = 2;
    case OTONOMIDAERAH = 3;

    public function title() :string
    {
        return match($this){
            self::TOKOH => 'tokoh',
            self::TOPIK => 'topik',
            self::OTONOMIDAERAH => 'otonomi daerah',
        };
    }

    /**
     * @return array<int,int>
     */
    public static function getValues() :array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }

    public static function getValueFromTitle(string $title) :int|null
    {
        foreach (self::cases() as $case) {
            if ($case->title() === $title) {
                return $case->value;
            }
        }

        return null;
    }

    /**
     * @param string $title
     * @return array<int>|null
     */
    public static function getValuesFromTitle(string $title) :array|null
    {
        $values = [];

        foreach (self::cases() as $case) {
            if (str_contains($case->title(),$title)) {
                $values[] = $case->value;
            }
        }

        return empty($values) ? null : $values;
    }

}