<?php

namespace App\Http\Controllers;

use App\DataTables\ProvinceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateProvinceRequest;
use App\Http\Requests\UpdateProvinceRequest;
use App\Repositories\ProvinceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Icon;
use App\Models\Province;
use App\Services\SaveFileService;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProvinceController extends AppBaseController
{
    /** @var  ProvinceRepository */
    private $provinceRepository;

    private $saveFileService;
    private $path = 'province';
    private $iconPath = 'icons/maps/province';

    public function __construct(ProvinceRepository $provinceRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:province-edit', ['only' => ['edit']]);
        $this->middleware('can:province-store', ['only' => ['store']]);
        $this->middleware('can:province-show', ['only' => ['show']]);
        $this->middleware('can:province-update', ['only' => ['update']]);
        $this->middleware('can:province-delete', ['only' => ['delete']]);
        $this->middleware('can:province-create', ['only' => ['create']]);
        $this->provinceRepository = $provinceRepo;
        $this->saveFileService = new SaveFileService();
    }

    /**
     * Display a listing of the Province.
     *
     * @param ProvinceDataTable $provinceDataTable
     * @return Response
     */
    public function index(ProvinceDataTable $provinceDataTable)
    {
        return $provinceDataTable->render('provinces.index');
    }

    /**
     * Show the form for creating a new Province.
     *
     * @return Response
     */
    public function create()
    {
        return view('provinces.create');
    }

    /**
     * Store a newly created Province in storage.
     *
     * @param CreateProvinceRequest $request
     *
     * @return Response
     */
    public function store(CreateProvinceRequest $request)
    {
        $input = $request->all();

        // $input['icon_map'] = $this->saveFileService->setImage(@$request->icon_map)->setStorage($this->path)->handle();
        // $input['province_code'] =null
        $province = $this->provinceRepository->create($input);
        $province->province_code = $province->id;
        $province->save();

        $province->icon()->create([
            'image' => $this->saveFileService->setImage(@$request->icon_map_blue)->setStorage($this->iconPath)->handle(),
            'color' => 'blue'
        ]);

        $province->icon()->create([
            'image' => $this->saveFileService->setImage(@$request->icon_map_green)->setStorage($this->iconPath)->handle(),
            'color' => 'green'
        ]);

        Flash::success('Province saved successfully.');
        return redirect(route('provinces.index'));
    }

    /**
     * Display the specified Province.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $province = $this->provinceRepository->findWithoutFail($id);

        if (empty($province)) {
            Flash::error('Province not found');
            return redirect(route('provinces.index'));
        }

        return view('provinces.show')->with('province', $province);
    }

    /**
     * Show the form for editing the specified Province.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $province = $this->provinceRepository->findWithoutFail($id);

        if (empty($province)) {
            Flash::error('Province not found');
            return redirect(route('provinces.index'));
        }

        return view('provinces.edit')
            ->with('province', $province)
            ->with('blue_icon', $province->blue())
            ->with('green_icon', $province->green());
    }

    /**
     * Update the specified Province in storage.
     *
     * @param  int              $id
     * @param UpdateProvinceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProvinceRequest $request)
    {
        $province = $this->provinceRepository->findWithoutFail($id);

        if (empty($province)) {
            Flash::error('Province not found');
            return redirect(route('provinces.index'));
        }

        // $icons = Icon::where('iconnable_id', $id)->where('iconnable_type', Province::class)->get();

        $input = $request->all();

        if (empty($province->blue())) {
            $province->icon()->create([
                'image' => $this->saveFileService->setImage(@$request->icon_map_blue)->setStorage($this->iconPath)->handle(),
                'color' => 'blue'
            ]);
        } else {
            $province->blue()->update([
                'image' => $this->saveFileService->setImage(@$request->icon_map_blue)->setModel($province->blue()->image)->setStorage($this->iconPath)->handle(),
            ]);
        }

        if (empty($province->green())) {
            $province->icon()->create([
                'image' => $this->saveFileService->setImage(@$request->icon_map_green)->setStorage($this->iconPath)->handle(),
                'color' => 'green'
            ]);
        } else {
            $province->green()->update([
                'image' => $this->saveFileService->setImage(@$request->icon_map_green)->setModel($province->green()->image)->setStorage($this->iconPath)->handle(),
            ]);
        }

        $province = $this->provinceRepository->update([
            'province_name' => $input['province_name']
        ], $id);

        Flash::success('Province updated successfully.');
        return redirect(route('provinces.index'));
    }

    /**
     * Remove the specified Province from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $province = $this->provinceRepository->findWithoutFail($id);

        if (empty($province)) {
            Flash::error('Province not found');
            return redirect(route('provinces.index'));
        }

        $this->saveFileService->setModel(@$province->blue()->image)->isDelete(1)->handle();
        $this->saveFileService->setModel(@$province->green()->image)->isDelete(1)->handle();

        $province->icon()->delete();
        $this->provinceRepository->delete($id);

        Flash::success('Province deleted successfully.');
        return redirect(route('provinces.index'));
    }

    /**
     * Store data Province from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $province = $this->provinceRepository->create($item->toArray());
            });
        });

        Flash::success('Province saved successfully.');
        return redirect(route('provinces.index'));
    }
}
