<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SkNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class SkNumberWebController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);

        $response = Http::get("{$this->baseUrl}/sk_number", [
            'page' => $page,
            'per_page' => $perPage
        ]);
        if ($response->successful()) {
            $data = $response->json();
            $skNumbers = $data['data']['data'] ?? [];
            $pagination = $data['data']; // karena paginate bawa meta+links
            return view('sknumber.index', compact('skNumbers', 'pagination'));
        }


        return view('sknumber.index')->with('error', 'Gagal mengambil data dari API');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('sknumber.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = (new \App\Http\Controllers\SkNumberController())->store($request);
        $data = $result->getData(true);
        if($data['code'] == 201){
            return redirect()->route('sk.index')->with('success', 'Berhasil menambah data');
        }
        return redirect()->route('sk.index')->withErrors(['Gagal menambah data']);
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
    public function edit(SkNumber $skNumber)
    {
        $categories = Category::all();
        return view('sknumber.edit',compact('categories','skNumber'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SkNumber  $skNumber)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'exists:categories,id',
            'description'=>'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $skNumber->category_id = $request->category_id;
        $skNumber->description = $request->description;
        $skNumber->save();
        return redirect()->route('sk.index')->with('success', 'Berhasil mengubah data');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
