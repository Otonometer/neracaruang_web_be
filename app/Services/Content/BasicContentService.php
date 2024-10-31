<?php

namespace App\Services\Content;

use App\Models\Content;
use App\Enums\ContentTypes;
use App\Enums\LocationTypes;
use App\Models\TagsContent;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Contracts\ContentService;
use App\Models\City;
use App\Services\SaveFileService;
use Illuminate\Support\Facades\DB;
use App\Repositories\ContentRepository;

class BasicContentService implements ContentService
{
    protected string $filePath = 'contents';

    public function __construct
    (
        protected ContentRepository $contentRepository,
        private TagsContent $tagsContent,
        protected SaveFileService $saveFileService
    )
    {
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        $data['image'] = isset($data['image']) ? $this->saveFileService->setImage($data['image'])->setStorage($this->filePath.'/'.ContentTypes::tryFrom($data['type_id'])->slug())->handle() : null;

        try {
            $content = $this->contentRepository->create([
                'title' => $data['title'],
                'slug' => $this->checkSlug($data['title']),
                'summary' => $data['summary'] ?? '',
                'content' => $data['content'] ?? '',
                'video' => $data['video'] ?? null,
                'location_id' => $data['location_id'] ?? City::where('city_name','indonesia')->first()?->id,
                'location_type' => $data['location_type'],
                'image' => $data['image'] ?? null,
                'page_type_id' => $data['type_id'],
                'created_by' => $data['created_by'],
                'publish_date' => $data['publish_date'],
                'status' => $data['status'],
            ]);

            foreach ($data['tags'] as $tag) {
                if (is_null($tag)) {
                    continue;
                }

                TagsContent::create([
                    'content_id' => $content->id,
                    'tag_id' => $tag
                ]);
            }

            DB::commit();

            return $content;
        } catch (\Throwable $th) {
            DB::rollBack();

            // change later
            dd($th->getMessage());
        }

    }

    public function update(Content $content,array $data)
    {
        $this->remakeContentTags($content->id,$data['tags']);

        if (isset($data['image'])) {
            $data['image'] = $this->saveFileService->setImage($data['image'])->setStorage($this->filePath.'/'.ContentTypes::tryFrom($data['type_id'])->slug())->handle();
        }

        $content->update([
            'title' => $data['title'],
            'slug' => $this->checkSlug($data['title']),
            'summary' => $data['summary'] ?? '',
            'content' => $data['content'] ?? '',
            'video' => $data['video'] ?? null,
            'location_id' => $data['location_type'] === LocationTypes::NATIONAL->value ? $content->location_id : $data['location_id'],
            'location_type' => $data['location_type'],
            'created_by' => $data['created_by'],
            'image' => $data['image'] ?? $content->image,
            'publish_date' => $data['publish_date'],
            'status' => $data['status']
        ]);
    }

    protected function checkSlug(string $title) :?string
    {
        $contentCounter = $this->contentRepository->where('slug','LIKE',Str::slug($title)."%")->count();

        return $contentCounter >= 1 ? Str::slug($title).'-'.$contentCounter : Str::slug($title);
    }

    protected function remakeContentTags(int $contentId, array $tags)
    {
        $this->tagsContent->where(['content_id' => $contentId])->delete();

        foreach ($tags as $tag) {
            if (!$tag) {
                continue;
            }

            $this->tagsContent->create([
                'content_id' => $contentId,
                'tag_id' => $tag
            ]);
        }
    }
}
