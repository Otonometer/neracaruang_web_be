<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('saveImage')) {
    function saveImage( $image, $storage, $isUpdate = false , $model = "") {
        $dir = Storage::directories();

        if (!in_array('public/'.$storage.'/' , $dir)) {
            Storage::makeDirectory('public/'.$storage.'/');
        }

        if(!empty($image)) {
            $fileImg = uniqid() . '.' . $image->getClientOriginalExtension();
            if ($isUpdate) {
                @Storage::delete('public/'.$storage.'/' . $model);
            }
            Storage::put('public/'.$storage.'/' . $fileImg, File::get($image));
            $image = $fileImg;
        }else{
            if ($isUpdate) {
                $image = $model;
            }else {
                $image = NULL;
            }
        }
        return $image;
    }

}

if (!function_exists('saveImageOriginalName')) {
    function saveImageOriginalName( $image, $storage, $isUpdate = false , $current_image = "") {
        $dir = Storage::directories();

        if (!in_array('public/'.$storage.'/' , $dir)) {
            Storage::makeDirectory('public/'.$storage.'/');
        }

        if(!empty($image)) {
            $fileImg = getNameFile($image->getClientOriginalName());
            if ($isUpdate) {
                @Storage::delete('public/'.$storage.'/' . $current_image);
            }
            Storage::put('public/'.$storage.'/' . $fileImg, File::get($image));
            $image = $fileImg;
        }else{
            if ($isUpdate) {
                $image = $current_image;
            }else {
                $image = NULL;
            }
        }
        return $image;
    }
}

if (!function_exists('getNameFile')) {
    function getNameFile($slug, $val = 0) {

        if ($val > 0) {
            $data = explode('.',$slug);
            if ($val == 1) {
                $slug = $data[0].'_'.$val;
            } else {
                $slug = explode("_", $data[0]);
                $length = count($slug);
                $last = $slug[$length-1];
                $slug[$length - 1] = $last+1;
                $slug = implode('_',$slug);
            }
            $slug = $slug.'.'.$data[1];
        }

        if(@Storage::exists($slug)){
            $result = getNameFile($slug, $val+1);
            return $result;
        }
        
        return $slug;
    }
}
