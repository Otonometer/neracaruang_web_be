<?php

namespace App\Services\Content\Api;

use App\Enums\ContentTypes;
use App\Enums\LocationTypes;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Repositories\TagRepository;
use App\Repositories\CityRepository;
use App\Repositories\ContentRepository;
use App\Repositories\ProvinceRepository;
use App\Http\Resources\Api\ContentResource;
use App\Http\Resources\Api\LandingPageResource;
use App\Http\Resources\Api\FilterContentResource;
use App\Models\Content;
use Carbon\Carbon;

class ContentService
{
    private LocationTypes $locationType;

    private array $params = [];

    private Collection $contents;

    private ?array $locationsId = [];

    private string $queryString = '';

    public function __construct
    (
        private ContentRepository $contentRepository,
        private CityRepository $cityRepository,
        private ProvinceRepository $provinceRepository,
        private TagRepository $tagRepository
    )
    {
    }

    private function setContentBuilder()
    {
        $this->contents = collect();

        foreach (ContentTypes::cases() as $type) {
            if(key_exists('sort_popular',$this->params)){
                $this->contents->put($type->value,$this->contentRepository->where('status','publish')
                    ->where('publish_date','<=',Carbon::now('Asia/Jakarta'))->with(['tags','writer'])->where('page_type_id',$type->value)->orderBy('reads','desc'));
            }else{
                $this->contents->put($type->value,$this->contentRepository->where('status','publish')
                    ->where('publish_date','<=',Carbon::now('Asia/Jakarta'))->with(['tags','writer'])->where('page_type_id',$type->value)->orderBy('publish_date','desc'));
            }

        }
    }

    public function getContents()
    {
        $this->setContentBuilder();

        $contents = $this->contents;

        if (empty($this->params)) {
            session(['region' => null]);
        }


        if (key_exists('tags',$this->params)) {
            foreach ($contents as $content) {
                $content->whereIn('id',$this->getFilteredTagsId($this->params['tags']));
            }
        }

        if (key_exists('keyword',$this->params)) {
            foreach ($contents as $content) {
                $content->where(function ($qr) {
                    return $qr->where('title','like','%'.$this->params['keyword'].'%')->orWhere('content','like','%'.$this->params['keyword'].'%');
                });
            }
        }

        if($this->locationsId){
            session(['region' => $this->params]);
            foreach ($contents as $content) {
                if($this->locationType === LocationTypes::NATIONAL){
                    $content->where('location_type',LocationTypes::NATIONAL->value);
                }elseif($this->locationType === LocationTypes::PROVINCE){
                    $content->where(function($query) {
                                $query->where(['location_type' => LocationTypes::PROVINCE->value,'location_id' => $this->locationsId[0] ?? false]);
                                array_shift($this->locationsId);
                                $query->orWhere('location_type', LocationTypes::CITY)
                                    ->whereIn('location_id',$this->locationsId);
                            });
                }else{
                    $content->where('location_type',LocationTypes::CITY->value)
                            ->whereIn('location_id',$this->locationsId);
                }
            }
        }

        if(key_exists('type',$this->params)){
            $contents = $contents[(ContentTypes::getValueFromSlug($this->params['type']))];
        }

        if ($contents instanceof Collection) {
            return new LandingPageResource($contents->all());
        }

        if(key_exists('sort_popular',$this->params)){
            $contents?->orderBy('reads','desc');
        }else{
            $contents?->orderBy('publish_date','desc');
        }

        $excludeContent = null;
        if(key_exists('content_slug',$this->params)){
            $contents = $contents->whereNot('slug',$this->params['content_slug']);
            if(request('page') <= 1){
            $excludeContent = $this->contentRepository
                                   ->where('slug',$this->params['content_slug'])
                                   ->get();
            }
        }

        $contents = $contents?->paginate(10);

        $contents?->getCollection()->transform(fn($content) => new ContentResource($content));

        if($excludeContent){
            $contents->getCollection()->prepend(new ContentResource($excludeContent[0]));
        }

        $contents?->setPath($contents->path()."?".$this->queryString);

        return new FilterContentResource($contents);
    }

    private function getFilteredTagsId(array $tags)
    {
        $tagsId = $this->tagRepository
                ->select(['id','category_id'])
                ->whereIn('slug',$tags)
                ->get()
                ->pluck('id')
                ->toArray();

        return $this->contentRepository->getContentIdsForSearchedTags($tagsId);
    }

    public function setParams(array $params = []) :self
    {
        $this->params = $params;

        if (isset($params['province'])) {
            $province = $this->provinceRepository
                          ->where('province_name',str_replace('-',' ',$params['province']))
                          ->with('cities')
                          ->first();
            $cities = $province?->cities->pluck('id');

            $this->locationsId[] = $province?->id;
            $cities?->each(fn ($city) => $this->locationsId[] = $city);


            $this->locationType = LocationTypes::PROVINCE;
        }

        if (isset($params['city'])) {
            unset($this->locationsId);
            $this->locationsId[] = $this->cityRepository->where('city_name',str_replace('-',' ',$params['city']))
                                    ->first()?->id;

            $this->locationType = $this->params['city'] !== 'indonesia' ? LocationTypes::CITY : LocationTypes::NATIONAL;
        }


        $this->queryString = preg_replace('/%5B\d+%5D/', '[]', request()->getQueryString());

        return $this;
    }

    public function getMetaKeyword(Content $content) :string
    {
        $keywords = [];

        if($content->location_type !== LocationTypes::NATIONAL->value){
            if($content->location_type === LocationTypes::CITY->value){
                $city = $content->location;
                $province = $city->province;
                $keywords[] = $province->province_name;
                $keywords[] = $city->city_name;
            }else{
                $keywords[] = $content->location->province_name;
            }
        }

        $content->tags?->each(function($tag) use(&$keywords){
            $keywords[] = $tag->title;
        });

        return implode(',',$keywords);
    }
}
