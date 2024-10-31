<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Http\Requests;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Services\SaveFileService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\DataTables\NotificationDataTable;
use App\Http\Controllers\AppBaseController;
use App\Repositories\NotificationRepository;
use App\Http\Requests\UpdateSocialMediaRequest;
use App\Http\Requests\CreateNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;

class NotificationController extends AppBaseController
{
    /** @var  NotificationRepository */
    private $notificationRepository;

    private $saveFileService;
    private $path = 'notification';

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:notification-store', ['only' => ['store']]);
        $this->middleware('can:notification-show', ['only' => ['show']]);;
        $this->middleware('can:notification-create', ['only' => ['create']]);
        $this->middleware('can:notification-edit', ['only' => ['edit']]);
        $this->middleware('can:notification-update', ['only' => ['update']]);
        $this->middleware('can:notification-delete', ['only' => ['delete']]);
        $this->notificationRepository = $notificationRepo;
        $this->saveFileService = new SaveFileService();
    }

    /**
     * Display a listing of the Notification.
     *
     * @param NotificationDataTable $notificationDataTable
     * @return Response
     */
    public function index(NotificationDataTable $notificationDataTable)
    {
        return $notificationDataTable->render('notifications.index');
    }

    /**
     * Show the form for creating a new Notification.
     *
     * @return Response
     */
    public function create()
    {
        return view('notifications.create');
    }

    /**
     * Store a newly created Notification in storage.
     *
     * @param CreateNotificationRequest $request
     *
     * @return Response
     */
    public function store(CreateNotificationRequest $request)
    {
        $input = $request->all();

        $input['image_uri'] = $this->saveFileService->setImage(@$request->image_uri)->setStorage($this->path)->handle();

        $notification = $this->notificationRepository->create($input);

        Flash::success('Notification saved successfully.');
        return redirect(route('notification.index'));
    }

    /**
     * Display the specified Notification.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            Flash::error('Notification not found');
            return redirect(route('notification.index'));
        }

        return view('notifications.show')->with('notification', $notification);
    }

    /**
     * Show the form for editing the specified SocialMedia.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            Flash::error('Notification not found');
            return redirect(route('notifications.index'));
        }

        return view('notifications.edit')
            ->with('notification', $notification);
    }

    /**
     * Update the specified Notification in storage.
     *
     * @param  int              $id
     * @param UpdateNotificationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNotificationRequest $request)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            Flash::error('Notification not found');
            return redirect(route('notification.index'));
        }

        $input = $request->all();
        $input['image_uri'] = $this->saveFileService->setImage(@$request->image)->setModel($notification->image_uri)->setStorage($this->path)->handle();
        $notification = $this->notificationRepository->update($input, $id);

        Flash::success('Notification updated successfully.');
        return redirect(route('notification.index'));
    }

    /**
     * Remove the specified Notification from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            Flash::error('Notification not found');
            return redirect(route('notifications.index'));
        }

        if ($notification->is_active == 1) {
            Flash::error('Notification must be inactive before deleting');
            return redirect(route('notification.index'));
        }

        $this->notificationRepository->delete($id);

        Flash::success('Notification deleted successfully.');
        return redirect(route('notification.index'));
    }

    /**
     * Store data SocialMedia from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $notification = $this->notificationRepository->create($item->toArray());
            });
        });

        Flash::success('Notification saved successfully.');
        return redirect(route('notification.index'));
    }
}
