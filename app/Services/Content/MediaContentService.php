<?php

namespace App\Services\Content;

use App\Enums\ContentTypes;
use App\Models\Content;
use App\Models\ContentMedia;
use Illuminate\Support\Facades\DB;
use App\Services\Content\ContentService;

class MediaContentService extends BasicContentService
{
    public function create(array $data)
    {
        try {
            $content = parent::create($data);

            foreach ($data['medias'] as $media) {
                if(isset($media['image'])){
                    $image = $this->saveFileService->setImage($media['image'])->setStorage($this->filePath.'/'.ContentTypes::tryFrom($data['type_id'])->slug())->handle();

                    if(empty($media['cms_document_value'])) $documentedBy = '';
                    else $documentedBy = @$media['cms_document_label']. ' ' .@$media['cms_document_value'];
                    
                    $content->medias()->create([
                        'media_type' => $data['type_id'] == ContentTypes::ALBUMFOTO->value ? 'image' : 'infografis',
                        'image' => $image,
                        'cms_document_label' => @$media['cms_document_label'],
                        'cms_document_value' => @$media['cms_document_value'],
                        'documented_by' => $documentedBy,
                        'summary' => @$media['summary']
                    ]);
                }
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
        parent::update($content,$data);

        if (isset($data['medias'])) {
            foreach ($data['medias'] as $media) {
                
                if(empty($media['cms_document_value'])) $documentedBy = '';
                else $documentedBy = @$media['cms_document_label']. ' ' .@$media['cms_document_value'];
                
                if (isset($media['id'])) {
                    if (isset($media['image'])) {
                        $media['image'] = $this->saveFileService->setImage($media['image'])->setStorage($this->filePath.'/'.ContentTypes::tryFrom($data['type_id'])->slug())->handle();
                    }

                    $updateMedia = ContentMedia::where(['id' => $media['id']])->first();

                    $updateMedia->update([
                        'content_id' => $content->id,
                        'image' => $media['image'] ?? $updateMedia->image,
                        'documented_by' => $documentedBy,
                        'cms_document_label' => @$media['cms_document_label'],
                        'cms_document_value' => @$media['cms_document_value'],
                        'summary' => @$media['summary']
                    ]);
                }else{
                    $media['image'] = $this->saveFileService->setImage($media['image'])->setStorage($this->filePath.'/'.ContentTypes::tryFrom($data['type_id'])->slug())->handle();

                    ContentMedia::create([
                        'content_id' => $content->id,
                        'media_type' => $data['type_id'] == ContentTypes::ALBUMFOTO->value ? 'image' : 'infografis',
                        'image' => $media['image'],
                        'documented_by' => $documentedBy,
                        'cms_document_label' => @$media['cms_document_label'],
                        'cms_document_value' => @$media['cms_document_value'],
                        'summary' => @$media['summary']
                    ]);
                }
            }
        }
    }
}
