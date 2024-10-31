<?php

namespace App\Services\Content\Api;

use App\Http\Resources\Api\Discussion\DiscussionResource;
use App\Repositories\DiscussionRepository;
use Carbon\Carbon;

class DiscussionService
{
    private array $params = [];

    private $baseQuery;

    private string $queryString = '';

    public function __construct
    (
        private DiscussionRepository $discussionRepository
    )
    {
        $this->baseQuery = $this->discussionRepository->with('moderator:id,name,image','co_moderator:id,name,image');
    }

    public function getContents()
    {
        $this->archive()->search()->sort();

        $discussions = $this->baseQuery->paginate(4);

        $discussions->getCollection()->transform(fn($discussion) => new DiscussionResource($discussion));

        $discussions->setPath($discussions->path()."?".$this->queryString);

        return $discussions;
    }

    public function getCollections()
    {
        $this->detail()->archive()->search()->sort();

        $discussions = $this->baseQuery->take(4)->get();

        $discussions->transform(fn($discussion) => new DiscussionResource($discussion));

        return $discussions;
    }

    private function detail()
    {
        if (isset($this->params['detail'])) {
            $this->baseQuery = $this->baseQuery->where('id','!=',$this->params['detail']);
        }

        return $this;
    }

    private function archive()
    {
        if (isset($this->params['archive']) && $this->params['archive'] == true) {
            $this->baseQuery = $this->baseQuery->whereStatus('archive')
                            ->orWhere('publish_date_end','<=',Carbon::now('Asia/Jakarta'));
        } else {
            $this->baseQuery = $this->baseQuery->whereStatus('publish')
                ->whereRaw('? between publish_date_start and publish_date_end', [Carbon::now('Asia/Jakarta')]);
        }

        return $this;
    }

    private function sort()
    {
        if (isset($this->params['sort_popular'])) {
            $this->baseQuery = $this->baseQuery->orderBy('reads','asc');
        } else {
            $this->baseQuery = $this->baseQuery->orderBy('publish_date_start','desc');
        }

        return $this;
    }

    private function search()
    {
        if (isset($this->params['keyword'])) {
            $this->baseQuery = $this->baseQuery->where(function($query){
                $query->whereHas('moderator', function($q){
                    $q->where('name','like','%'.$this->params['keyword'].'%');
                    return $q;
                })->orWhereHas('co_moderator', function($q){
                    $q->where('name','like','%'.$this->params['keyword'].'%');
                    return $q;
                })->orWhere('title','like','%'.$this->params['keyword'].'%')
                    ->orWhere('content','like','%'.$this->params['keyword'].'%');
            });
        }

        return $this;
    }

    public function setParams(array $params = []) :self
    {
        $this->params = $params;

        $this->queryString = preg_replace('/%5B\d+%5D/', '[]', request()->getQueryString());

        return $this;
    }

}
