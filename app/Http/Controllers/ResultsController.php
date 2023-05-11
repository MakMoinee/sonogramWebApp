<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (session()->exists("users")) {
            $id = $request->query("id");
            return view('loading', ['id' => $id]);
        } else {
            return redirect("/");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showResults(Request $request)
    {
        if (session()->exists("users")) {

            $id = $request->query("id");
            if ($id) {

                $queryResult = DB::table("vwResults")->where("sonogramID", $id)->get();
                $results = json_decode($queryResult, true);

                return view('results', ['results' => $results[0]]);
            } else {
                return redirect("/");
            }
        } else {
            return redirect("/");
        }
    }
}
