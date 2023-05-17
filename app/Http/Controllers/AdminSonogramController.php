<?php

namespace App\Http\Controllers;

use App\Models\Results;
use App\Models\Sonogram;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
                        "status" => "Successful",
                        "remarks" => "See Results"
                    ]);
                if ($affectedRows > 0) {
                    session()->put("successUpdate", true);
                    $queryResult = DB::table("sonograms")->where('sonogramID',$id)->get();
                    $data = json_decode($queryResult,true);

                    $this->callApi($id, $data[0]['imagePath']);

                    // $generatedResult = $this->getDetails(rand(1, 3));
                    // $generatedResult->sonogramID = $id;
                    // $isSave = $generatedResult->save();
                    // if ($isSave) {
                    //     session()->put("successUpdate", true);
                    //     $this->callApi($id);
                    // } else {
                    //     $affectedRows = DB::table("sonograms")
                    //         ->where("sonogramID", $id)
                    //         ->update([
                    //             "status" => "In Progress",
                    //             "remarks" => ""
                    //         ]);
                    //     session()->put("errorcUpdate", true);
                    // }
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


    private function getDetails(int $randomNum): Results
    {
        $newResults = new Results();

        $list = $this->getListOfDetails();
        $newResults = $list[$randomNum - 1];
        return $newResults;
    }

    private function getListOfDetails(): Collection
    {
        $result = collect();
        $arr = array();

        $newResult = new Results();
        $newResult->age = "1-2 years old";
        $newResult->pregnancyStage = "Pre-pregnancy";
        $newResult->numberOfFetus = "Singleton (One Fetus)";
        $newResult->healthStatus = "Excellent";
        array_push($arr, $newResult);

        $newResult = new Results();
        $newResult->age = "3-4 years old";
        $newResult->pregnancyStage = "Early pregnancy (1-4 weeks)";
        $newResult->numberOfFetus = "Two-Four Fetuses";
        $newResult->healthStatus = "Good";
        array_push($arr, $newResult);

        $newResult = new Results();
        $newResult->age = "5-6 years old";
        $newResult->pregnancyStage = "Mid-pregnancy (4-6 weeks)";
        $newResult->numberOfFetus = "Five or More Fetuses";
        $newResult->healthStatus = "Fair";
        array_push($arr, $newResult);

        $result = collect($arr);

        return $result;
    }

    private function callApi(string $id, string $imagePath): void
    {
        $client = new Client();
        $response = $client->post('http://localhost:5000/detect', [
            'multipart' => [
                [
                    'name' => 'id',
                    'contents' => $id
                ],
                [
                    'name' => 'image_url',
                    'contents' => $imagePath
                ]
            ]
        ]);

        // var_dump($response->getBody()->getContents());
    }
}
