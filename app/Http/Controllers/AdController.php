<?php

namespace App\Http\Controllers;

use App\DataTables\AdDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAdRequest;
use App\Http\Requests\UpdateAdRequest;
use App\Repositories\AdRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\City;
use App\Models\Province;
use App\Services\SaveFileService;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AdController extends AppBaseController
{
    /** @var  AdRepository */
    private $adRepository;
    private $saveFileService;
    private $path = 'ads';

    public function __construct(AdRepository $adRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:ad-edit', ['only' => ['edit']]);
        $this->middleware('can:ad-store', ['only' => ['store']]);
        $this->middleware('can:ad-show', ['only' => ['show']]);
        $this->middleware('can:ad-update', ['only' => ['update']]);
        $this->middleware('can:ad-delete', ['only' => ['delete']]);
        $this->middleware('can:ad-create', ['only' => ['create']]);
        $this->adRepository = $adRepo;
        $this->saveFileService = new SaveFileService();
    }

    /**
     * Display a listing of the Ad.
     *
     * @param AdDataTable $adDataTable
     * @return Response
     */
    public function index(AdDataTable $adDataTable)
    {
        return $adDataTable->render('ads.index');
    }

    /**
     * Show the form for creating a new Ad.
     *
     * @return Response
     */
    public function create()
    {
        $province = Province::select('id', 'province_name')->get();
        $city = City::all();
        return view('ads.create')
                ->with('province', $province)
                ->with('city', $city);
    }

    /**
     * Store a newly created Ad in storage.
     *
     * @param CreateAdRequest $request
     *
     * @return Response
     */
    public function store(CreateAdRequest $request)
    {
        $input = $request->all();
        $input['image'] = $this->saveFileService->setImage(@$request->image)->setStorage($this->path)->handle();

        if ($input['location_type'] == 'province') {
            $input['location_id'] = $input['province'];
        } else if ($input['location_type'] == 'city') {
            $input['location_id'] = $input['city'];
        }

        $ad = $this->adRepository->create($input);

        Flash::success('Ad saved successfully.');
        return redirect(route('ads.index'));
    }

    /**
     * Display the specified Ad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ad = $this->adRepository->findWithoutFail($id);

        if ($ad->location_type == 'province') {
            $data = Province::select('id', 'province_name')->whereId($ad->location_id)->first();
            $location = $data->province_name;
        } else if ($ad->location_type == 'city') {
            $data = City::select('id', 'city_name')->whereId($ad->location_id)->first();
            $location = $data->city_name;
        } else {
            $location = '';
        }

        if (empty($ad)) {
            Flash::error('Ad not found');
            return redirect(route('ads.index'));
        }

        return view('ads.show')->with('ad', $ad)->with('location', $location);
    }

    /**
     * Show the form for editing the specified Ad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ad = $this->adRepository->findWithoutFail($id);
        $province = Province::select('id', 'province_name')->get();
        $city = City::all();

        if (empty($ad)) {
            Flash::error('Ad not found');
            return redirect(route('ads.index'));
        }

        return view('ads.edit')
            ->with('ad', $ad)
            ->with('province', $province)
            ->with('city', $city);
    }

    /**
     * Update the specified Ad in storage.
     *
     * @param  int              $id
     * @param UpdateAdRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdRequest $request)
    {
        $ad = $this->adRepository->findWithoutFail($id);

        if (empty($ad)) {
            Flash::error('Ad not found');
            return redirect(route('ads.index'));
        }

        $input = $request->all();
        $input['image'] = $this->saveFileService->setImage(@$request->image)->setModel($ad->image)->setStorage($this->path)->handle();

        if ($input['location_type'] == 'province') {
            $input['location_id'] = $input['province'];
        } else if ($input['location_type'] == 'city') {
            $input['location_id'] = $input['city'];
        }

        $ad = $this->adRepository->update($input, $id);

        Flash::success('Ad updated successfully.');
        return redirect(route('ads.index'));
    }

    /**
     * Remove the specified Ad from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $ad = $this->adRepository->findWithoutFail($id);

        if (empty($ad)) {
            Flash::error('Ad not found');
            return redirect(route('ads.index'));
        }

        $this->adRepository->delete($id);

        Flash::success('Ad deleted successfully.');
        return redirect(route('ads.index'));
    }

    /**
     * Store data Ad from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $ad = $this->adRepository->create($item->toArray());
            });
        });

        Flash::success('Ad saved successfully.');
        return redirect(route('ads.index'));
    }
}
