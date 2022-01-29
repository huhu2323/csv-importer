<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequest;
use App\Imports\CelebrityImports;
use App\Models\Celebrity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class CelebrityController extends Controller
{

    public function form(Request $request)
    {
        $celebrities = Celebrity::query();
        $years = Celebrity::get()->unique('year')->pluck('year');
        $ranks = Celebrity::get()->unique('rank')->pluck('rank');
        $countries = Celebrity::get()->unique('country')->pluck('country');
        $careers = Celebrity::get()->unique('career')->pluck('career');

        if ($request->year) {
            $celebrities = $celebrities->where('year', $request->year);
        }

        if ($request->rank) {
            $celebrities = $celebrities->where('rank', $request->rank);
        }

        if ($request->country) {
            $celebrities = $celebrities->where('country', $request->country);
        }

        if ($request->career) {
            $celebrities = $celebrities->where('career', $request->career);
        }

        if ($request->recipient) {
            $celebrities = $celebrities->where('recipient', 'like', '%'.$request->recipient.'%');
        }

        if ($request->title) {
            $celebrities = $celebrities->where('title', 'like', '%'.$request->title.'%');
        }

        $celebrities = $celebrities->get();

        return view('form', compact(
            'celebrities',
            'years',
            'ranks',
            'countries',
            'careers'
        ));
    }

    public function store(FormRequest $request)
    {
        Celebrity::truncate();
        Excel::import(new CelebrityImports, $request->csv_file);

        return redirect()->route('form');
    }
}
