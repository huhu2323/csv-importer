<?php

namespace App\Imports;

use App\Models\Celebrity;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CelebrityImports implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return Celebrity|null
     */
    public function model(array $row)
    {
        return new Celebrity([
            'year' => $row['year'],
            'rank' => $row['rank'],
            'recipient' => $row['recipient'],
            'country' => $row['country'],
            'career' => $row['career'],
            'tied' => $row['tied'],
            'title' => $row['title']
        ]);
    }

    public function rules(): array
    {
        return [
            'year' => 'required|numeric',
            'rank' => 'required|numeric',
            'recipient' => 'required',
            'country' => 'required',
            'career' => 'required',
            'tied' => 'required|numeric',
            'title' => 'required'
        ];
    }
}
