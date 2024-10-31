<?php

namespace App\Factories;

use App\Contracts\ContentService;
use App\Enums\ContentTypes;
use App\Models\Content;
use App\Services\Content\BasicContentService;
use App\Services\Content\MediaContentService;

class ContentServiceFactory  
{
    public function create(array $data)
    {
        $service = $this->getService(ContentTypes::tryFrom($data['type_id']));

        return $service->create($data);
    }

    public function update(Content $content,array $data)
    {
        $service = $this->getService(ContentTypes::tryFrom($data['type_id']));

        return $service->update($content,$data);
    }

    private function getService(ContentTypes $contentTypes) :ContentService
    {
        if ($contentTypes === ContentTypes::ALBUMFOTO || $contentTypes === ContentTypes::INFOGRAFIS) {
            return app(MediaContentService::class);
        }

        return app(BasicContentService::class);
    }
}

