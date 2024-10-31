<?php

namespace App\Enums;

use Illuminate\Support\Str;
enum ContentTypes :int
{
    case KABAR = 1;
    case JURNAL = 2;
    case INFOGRAFIS = 3;
    case VIDEO = 4;
    case ALBUMFOTO = 5;

    public function title()
    {
        return match($this)
        {
            self::KABAR => 'kabar',
            self::JURNAL => 'jurnal',
            self::INFOGRAFIS => 'info grafis',
            self::VIDEO => 'video',
            self::ALBUMFOTO => 'album foto',
        };
    }

    public function slug() :string
    {
        return Str::slug($this->title());
    }

    public static function getValueFromSlug(string $slug) :?int
    {
        foreach (self::cases() as $case) {
            if ($case->slug() === $slug) {
                return $case->value;
            }
        }

        return null;
    }

    public static function mediaContents() :array
    {
        return [self::INFOGRAFIS->value,self::ALBUMFOTO->value];
    }
}
