<?php

namespace App\Http\Controllers;

use App\Models\Writer;
use Illuminate\Http\Request;
use App\Http\Requests\CreateWriterRequest;
use App\DataTables\WriterDataTable;

class WriterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WriterDataTable $dataTable)
    {
        return $dataTable->render('writers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('writers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateWriterRequest $request)
    {
        $writer = Writer::create([
            'name' => $request->name
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Writer Created Successfully',
                'data' => $writer
            ],201);
        }

        return redirect()->route('writer.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $writer = Writer::find($id);

        if(!$writer){
            return redirect()->route('writer.index');
        }

        return view('writers.show',compact('writer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $writer = Writer::find($id);

        if(!$writer){
            return redirect()->route('writer.index');
        }

        return view('writers.edit',compact('writer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $writer = Writer::find($id);

        if(!$writer){
            return redirect()->route('writer.index');
        }

        $writer->update($request->all());

        return redirect()->route('writer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $writer = Writer::find($id);

        if(!$writer){
            return redirect()->route('writer.index');
        }

        $writer->delete();

        return redirect()->route('writer.index');
    }
}
