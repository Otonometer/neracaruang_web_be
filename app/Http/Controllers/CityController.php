<?php

namespace App\Http\Controllers;

use Flash;
use App\Models\Province;
use Response;
use App\Models\City;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\DataTables\CityDataTable;
use App\Services\SaveFileService;
use App\Repositories\CityRepository;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Http\Controllers\AppBaseController;

class CityController extends AppBaseController
{
    /** @var  CityRepository */
    private $cityRepository;

    private $provinces;
    private $saveFileService;
    private $path = 'city';
    private $iconPath = 'icons/maps/city';

    public function __construct(CityRepository $cityRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:city-edit', ['only' => ['edit']]);
        $this->middleware('can:city-store', ['only' => ['store']]);
        $this->middleware('can:city-show', ['only' => ['show']]);
        $this->middleware('can:city-update', ['only' => ['update']]);
        $this->middleware('can:city-delete', ['only' => ['delete']]);
        $this->middleware('can:city-create', ['only' => ['create']]);
        $this->cityRepository = $cityRepo;
        $this->provinces = Province::pluck('province_name','id')->prepend('','');
        $this->saveFileService = new SaveFileService();
    }

    /**
     * Display a listing of the City.
     *
     * @param CityDataTable $cityDataTable
     * @return Response
     */
    public function index(CityDataTable $cityDataTable)
    {
        return $cityDataTable->render('cities.index');
    }

    /**
     * Show the form for creating a new City.
     *
     * @return Response
     */
    public function create()
    {
        return view('cities.create')
            ->with('provinces', $this->provinces);
    }

    /**
     * Store a newly created City in storage.
     *
     * @param CreateCityRequest $request
     *
     * @return Response
     */
    public function store(CreateCityRequest $request)
    {
        $input = $request->all();

        // $input['icon_map'] = $this->saveFileService->setImage(@$request->icon_map)->setStorage($this->path)->handle();

        $city = $this->cityRepository->create($input);

        $city->icon()->create([
            'image' => $this->saveFileService->setImage(@$request->icon_map_blue)->setStorage($this->iconPath)->handle(),
            'color' => 'blue'
        ]);

        $city->icon()->create([
            'image' => $this->saveFileService->setImage(@$request->icon_map_green)->setStorage($this->iconPath)->handle(),
            'color' => 'green'
        ]);

        Flash::success('City saved successfully.');
        return redirect(route('cities.index'));
    }

    /**
     * Display the specified City.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $city = $this->cityRepository->findWithoutFail($id);

        if (empty($city)) {
            Flash::error('City not found');
            return redirect(route('cities.index'));
        }

        return view('cities.show')->with('city', $city);
    }

    /**
     * Show the form for editing the specified City.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $city = $this->cityRepository->findWithoutFail($id);

        if (empty($city)) {
            Flash::error('City not found');
            return redirect(route('cities.index'));
        }

        return view('cities.edit')
            ->with('city', $city)
            ->with('provinces', $this->provinces)
            ->with('blue_icon', $city->blue())
            ->with('green_icon', $city->green());;
    }

    /**
     * Update the specified City in storage.
     *
     * @param  int              $id
     * @param UpdateCityRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCityRequest $request)
    {
        $city = $this->cityRepository->findWithoutFail($id);

        if (empty($city)) {
            Flash::error('City not found');
            return redirect(route('cities.index'));
        }

        $input = $request->all();

        // $input['icon_map'] = $this->saveFileService->setImage(@$request->icon_map)->setModel($city->icon_map)->setStorage($this->path)->handle();

        if (empty($city->blue())) {
            $city->icon()->create([
                'image' => $this->saveFileService->setImage(@$request->icon_map_blue)->setStorage($this->iconPath)->handle(),
                'color' => 'blue'
            ]);
        } else {
            $city->blue()->update([
                'image' => $this->saveFileService->setImage(@$request->icon_map_blue)->setModel($city->blue()->image)->setStorage($this->iconPath)->handle(),
            ]);
        }

        if (empty($city->green())) {
            $city->icon()->create([
                'image' => $this->saveFileService->setImage(@$request->icon_map_green)->setStorage($this->iconPath)->handle(),
                'color' => 'green'
            ]);
        } else {
            $city->green()->update([
                'image' => $this->saveFileService->setImage(@$request->icon_map_green)->setModel($city->green()->image)->setStorage($this->iconPath)->handle(),
            ]);
        }

        $city = $this->cityRepository->update([
            'province_code' => $input['province_code'],
            'city_name' => $input['city_name']
        ], $id);

        Flash::success('City updated successfully.');
        return redirect(route('cities.index'));
    }

    /**
     * Remove the specified City from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $city = $this->cityRepository->findWithoutFail($id);

        if (empty($city)) {
            Flash::error('City not found');
            return redirect(route('cities.index'));
        }
        $this->saveFileService->setModel(@$city->blue()->image)->isDelete(1)->handle();
        $this->saveFileService->setModel(@$city->green()->image)->isDelete(1)->handle();

        $city->icon()->delete();
        $this->cityRepository->delete($id);
        // $this->saveFileService->setModel($city->icon_map)->isDelete(1)->handle();

        Flash::success('City deleted successfully.');
        return redirect(route('cities.index'));
    }

    /**
     * Store data City from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $city = $this->cityRepository->create($item->toArray());
            });
        });

        Flash::success('City saved successfully.');
        return redirect(route('cities.index'));
    }
}
