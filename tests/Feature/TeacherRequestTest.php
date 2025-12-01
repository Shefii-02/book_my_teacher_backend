<?php

namespace Tests\Feature;

use App\Http\Requests\TeacherRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class TeacherRequestTest extends TestCase
{
    public function test_validation_fails_without_required_fields()
    {
        $request = new TeacherRequest();

        $validator = Validator::make([], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
        $this->assertArrayHasKey('price_per_hour', $validator->errors()->toArray());
        $this->assertArrayHasKey('year_exp', $validator->errors()->toArray());
    }

    public function test_validation_passes_with_minimum_fields()
    {
        $request = new TeacherRequest();

        $validator = Validator::make([
            'name' => 'John',
            'price_per_hour' => 200,
            'year_exp' => 2
        ], $request->rules());

        $this->assertFalse($validator->fails());
    }
}
