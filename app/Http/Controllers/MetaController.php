<?php

namespace App\Http\Controllers;

use App\DataTables\MetaDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMetaRequest;
use App\Http\Requests\UpdateMetaRequest;
use App\Repositories\MetaRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MetaController extends AppBaseController
{
    /** @var  MetaRepository */
    private $metaRepository;

    public function __construct(MetaRepository $metaRepo)
    {
        $this->middleware('auth');
        // $this->middleware('can:meta-edit', ['only' => ['edit']]);
        // $this->middleware('can:meta-store', ['only' => ['store']]);
        // $this->middleware('can:meta-show', ['only' => ['show']]);
        // $this->middleware('can:meta-update', ['only' => ['update']]);
        // $this->middleware('can:meta-delete', ['only' => ['delete']]);
        // $this->middleware('can:meta-create', ['only' => ['create']]);
        $this->metaRepository = $metaRepo;
    }

    /**
     * Display a listing of the Meta.
     *
     * @param MetaDataTable $metaDataTable
     * @return Response
     */
    public function index(MetaDataTable $metaDataTable)
    {
        return $metaDataTable->render('metas.index');
    }

    /**
     * Show the form for creating a new Meta.
     *
     * @return Response
     */
    public function create()
    {
        return view('metas.create');
    }

    /**
     * Store a newly created Meta in storage.
     *
     * @param CreateMetaRequest $request
     *
     * @return Response
     */
    public function store(CreateMetaRequest $request)
    {
        $input = $request->validated();

        $meta = $this->metaRepository->where('page_id',$request->page_id)
                ->first();

        if(!$meta){
            $this->metaRepository->create($input);
        }else{
            $meta->update($input);
        }

        return response()->json([
            'message' => $meta ? 'Meta updated' : 'Meta created'
        ]);
    }

    /**
     * Display the specified Meta.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $meta = $this->metaRepository->findWithoutFail($id);

        if (empty($meta)) {
            Flash::error('Meta not found');
            return redirect(route('metas.index'));
        }

        return view('metas.show')->with('meta', $meta);
    }

    /**
     * Show the form for editing the specified Meta.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {



        $meta = $this->metaRepository->findWithoutFail($id);

        if (empty($meta)) {
            Flash::error('Meta not found');
            return redirect(route('metas.index'));
        }

        return view('metas.edit')
            ->with('meta', $meta);
    }

    /**
     * Update the specified Meta in storage.
     *
     * @param  int              $id
     * @param UpdateMetaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMetaRequest $request)
    {
        $meta = $this->metaRepository->findWithoutFail($id);

        if (empty($meta)) {
            Flash::error('Meta not found');
            return redirect(route('metas.index'));
        }

        $input = $request->all();
        $meta = $this->metaRepository->update($input, $id);

        Flash::success('Meta updated successfully.');
        return redirect(route('metas.index'));
    }

    /**
     * Remove the specified Meta from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $meta = $this->metaRepository->findWithoutFail($id);

        if (empty($meta)) {
            Flash::error('Meta not found');
            return redirect(route('metas.index'));
        }

        $this->metaRepository->delete($id);

        Flash::success('Meta deleted successfully.');
        return redirect(route('metas.index'));
    }

    /**
     * Store data Meta from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $meta = $this->metaRepository->create($item->toArray());
            });
        });

        Flash::success('Meta saved successfully.');
        return redirect(route('metas.index'));
    }
}
