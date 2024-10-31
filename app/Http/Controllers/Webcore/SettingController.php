<?php

namespace App\Http\Controllers\Webcore;

use App\Http\Requests\CreateSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Repositories\SettingRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth; // added by dandisy
use Illuminate\Support\Facades\Storage; // added by dandisy
use Maatwebsite\Excel\Facades\Excel; // added by dandisy

class SettingController extends AppBaseController
{
    /** @var  SettingRepository */
    private $settingRepository;

    public function __construct(SettingRepository $settingRepo)
    {
        $this->middleware('auth');
        $this->settingRepository = $settingRepo;
    }

    /**
     * Display a listing of the Setting.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->settingRepository->pushCriteria(new RequestCriteria($request));
        $settings = $this->settingRepository->all();

        return view('settings.index')
            ->with('settings', $settings);
    }

    /**
     * Show the form for creating a new Setting.
     *
     * @return Response
     */
    public function create()
    {
        // added by dandisy
        

        // edited by dandisy
        // return view('settings.create');
        return view('settings.create');
    }

    /**
     * Store a newly created Setting in storage.
     *
     * @param CreateSettingRequest $request
     *
     * @return Response
     */
    public function store(CreateSettingRequest $request)
    {
        $input = $request->all();

        $input['created_by'] = Auth::user()->id;
        $input['updated_by'] = Auth::user()->id;

        $setting = $this->settingRepository->create($input);

        Flash::success('Setting saved successfully.');

        return redirect(route('settings.index'));
    }

    /**
     * Display the specified Setting.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $setting = $this->settingRepository->findWithoutFail($id);

        if (empty($setting)) {
            Flash::error('Setting not found');

            return redirect(route('settings.index'));
        }

        return view('settings.show')->with('setting', $setting);
    }

    /**
     * Show the form for editing the specified Setting.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        // added by dandisy
        

        $setting = $this->settingRepository->findWithoutFail($id);

        if (empty($setting)) {
            Flash::error('Setting not found');

            return redirect(route('settings.index'));
        }

        // edited by dandisy
        // return view('settings.edit')->with('setting', $setting);
        return view('settings.edit')
            ->with('setting', $setting);        
    }

    /**
     * Update the specified Setting in storage.
     *
     * @param  int              $id
     * @param UpdateSettingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSettingRequest $request)
    {
        $setting = $this->settingRepository->findWithoutFail($id);

        if (empty($setting)) {
            Flash::error('Setting not found');

            return redirect(route('settings.index'));
        }
        
        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;

        $setting = $this->settingRepository->update($input, $id);

        Flash::success('Setting updated successfully.');

        return redirect(route('settings.index'));
    }

    /**
     * Remove the specified Setting from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $setting = $this->settingRepository->findWithoutFail($id);

        if (empty($setting)) {
            Flash::error('Setting not found');

            return redirect(route('settings.index'));
        }

        $this->settingRepository->delete($id);

        Flash::success('Setting deleted successfully.');

        return redirect(route('settings.index'));
    }

    /**
     * Store data Setting from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $setting = $this->settingRepository->create($item->toArray());
            });
        });

        Flash::success('Setting saved successfully.');

        return redirect(route('settings.index'));
    }
}
