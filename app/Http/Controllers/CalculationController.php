<?php

namespace App\Http\Controllers;

use App\Calculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CalculationController extends Controller
{
    public function postCalculation(Request $request) {

        $validated = Validator::make($request->all(), $this->rules(), $this->messages());
        if($validated->errors()->count()) {
            return response()->json($validated->errors(), 422);
        }
        $first_operand = $request->first_operand;
        $second_operand = $request->second_operand;
        $operator = $request->operator;
        $result = eval('return '.($first_operand.$operator.$second_operand).';');

        $calculation = Calculation::create([
            'first_operand' => $first_operand,
            'second_operand' => $second_operand,
            'operator' => $operator,
            'result' => $result
        ]);
        return response()->json($calculation, 201);
    }

    public function getLatestCalculation() {
        $latestCalculations = Calculation::latest()->take(5)->get();
        return response()->json($latestCalculations);
    }

    private function rules() {
        return [
            'first_operand' => 'required|numeric',
            'second_operand' => 'required|numeric',
            'operator' => [
                'required',
                Rule::in(['+', '-'])
            ]
        ];
    }
    private function messages() {
        return [
            'required' => 'The :attribute can not be blank.',
            'numeric' => 'The :attribute must be numeric.',
            'in'    => 'The :attribute must be either + or -.'
        ];
    }
}
