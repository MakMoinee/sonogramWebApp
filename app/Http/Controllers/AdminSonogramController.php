<?php

namespace App\Http\Controllers;

use App\Models\Sonogram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSonogramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);
            $userType = $mUser[0]['userType'];

            if ($userType != 1) {
                return redirect("/");
            }
            $queryResult = DB::table("vwSonograms")->get();
            $sonograms = json_decode($queryResult, true);
            return view("admin.sonogram", ['sonograms' => $sonograms]);
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
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);
            $userType = $mUser[0]['userType'];

            if ($userType != 1) {
                return redirect("/");
            }
            if (isset($request->btnAcceptSonogram)) {
                $affectedRows = DB::table("sonograms")
                    ->where("sonogramID", $id)
                    ->update([
                        "status" => "Accepted",
                        "remarks" => "Generating Results"
                    ]);
                if ($affectedRows > 0) {
                    session()->put("successUpdate", true);
                } else {
                    session()->put("errorcUpdate", true);
                }
            }
            return redirect("/adminsono");
        } else {
            return redirect("/");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);
            $userType = $mUser[0]['userType'];

            if ($userType != 1) {
                return redirect("/");
            }

            if (isset($request->btnDeclineSonogram)) {
                $affectedRows = DB::table("sonograms")
                    ->where("sonogramID", $id)
                    ->update([
                        "status" => "Decline",
                        "remarks" => $request->remarks
                    ]);

                if ($affectedRows > 0) {
                    session()->put("successDecline", true);
                } else {
                    session()->put("errorcDecline", true);
                }
            }

            return redirect("/adminsono");
        } else {
            return redirect("/");
        }
    }
}
