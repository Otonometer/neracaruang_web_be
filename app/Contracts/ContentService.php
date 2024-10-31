<?php

namespace App\Contracts;

use App\Models\Content;

interface ContentService
{
    public function create(array $data);

    public function update(Content $content,array $data);
}