<?php

namespace Tests\Unit;

use App\Calculation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalculationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testEmptyData()
    {
        $data = [
          'first_operand' => '',
          'second_operand' => '',
          'operator' => ''
        ];
        $response = $this->json('POST', '/api/calculation', $data);
        $response->assertStatus(422);
        $response->assertJson([
            "first_operand" => [
                0 => "The first operand can not be blank."
            ],
            "second_operand" =>  [
                0 => "The second operand can not be blank."
            ],
            "operator" => [
                0 => "The operator can not be blank."
            ]
        ]);
//        dd($response);
    }

    public function testInvalidData() {
        $data = [
            'first_operand' => 'a',
            'second_operand' => 'b',
            'operator' => '*'
        ];
        $response = $this->json('POST', '/api/calculation', $data);
        $response->assertStatus(422);
        $response->assertJson([
            "first_operand" => [
                0 => "The first operand must be numeric."
            ],
            "second_operand" =>  [
                0 => "The second operand must be numeric."
            ],
            "operator" => [
                0 => "The operator must be either + or -."
            ]
        ]);
    }

    public function testAdditionInsert() {
        $data = [
            'first_operand' => '5',
            'second_operand' => '3',
            'operator' => '+'
        ];
        $response = $this->json('POST', '/api/calculation', $data);
        $response->assertStatus(201);
        $response->assertJson([
            "result" => 8
        ]);
    }

    public function testSubtractionInsert() {
        $data = [
            'first_operand' => '5',
            'second_operand' => '3',
            'operator' => '-'
        ];
        $response = $this->json('POST', '/api/calculation', $data);
        $response->assertStatus(201);
        $response->assertJson([
            "result" => 2
        ]);
    }

    public function testGetLatest() {
        Calculation::truncate();
        for($i=0; $i<=10; $i++) {
            Calculation::create([
                'first_operand' => 5,
                'second_operand' => 3,
                'operator' => '+',
                'result' => 8
            ]);
        }
        $response = $this->json('GET', '/api/latest-calculations');
        $response->assertStatus(200);

        $response->assertJsonCount(5);
    }
}
