<?php

namespace Tests\Unit\Enum;

use App\Enums\SubjectTypes;
use PHPUnit\Framework\TestCase;

class SubjectTypeTest extends TestCase
{
    public function test_get_value_from_title()
    {
        $value = SubjectTypes::getValueFromTitle('topik');

        $this->assertEquals(2,$value);
    }

    public function test_get_values_from_title()
    {
        $values = SubjectTypes::getValuesFromTitle('o');

        $this->assertCount(3,$values);
    }

    public function test_get_title()
    {
        $title = SubjectTypes::TOPIK->title();

        $this->assertEquals('topik',$title);
    }

    public function test_values_not_found_from_searched_title()
    {
        $values = SubjectTypes::getValuesFromTitle('oho');

        $this->assertNull($values);       
    }

    public function test_value_not_found()
    {
        $value = SubjectTypes::tryFrom(0);

        $this->assertNull($value);

    }
}
