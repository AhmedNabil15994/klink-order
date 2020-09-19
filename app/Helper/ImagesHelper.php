<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class ImagesHelper {

    static function GetImagePath($strAction, $id, $filename) {

        $default = URL::to('/assets/images/not-available.jpg');

        if($filename == '') {
            return $default;
        }

        $path = Config::get('app.IMAGE_BASE');
        $checkFile = public_path() . '/uploads';
        $checkFile = str_replace('frontend', 'backend', $checkFile);

        switch ($strAction) {
            case "user":
                $fullPath = $path . '/users/' . $id . '/' . $filename;
                $checkFile = $checkFile . '/users/' . $id . '/' . $filename;
                return is_file($checkFile) ? URL::to($fullPath) : $default;
                break;
            case "shipping":
                $fullPath = $path . '/shippings/' . $id . '/' . $filename;
                $checkFile = $checkFile . '/shippings/' . $id . '/' . $filename;
                return is_file($checkFile) ? URL::to($fullPath) : $default;
                break;
            case "task":
                $fullPath = $path . '/tasks/' . $id . '/' . $filename;
                $checkFile = $checkFile . '/tasks/' . $id . '/' . $filename;
                return is_file($checkFile) ? URL::to($fullPath) : $default;
                break;

        }

        return $default;
    }

    static function uploadImage($strAction, $fieldInput, $id, $customPath = '') {

        if ($fieldInput == '') {
            return false;
        }

        if (is_object($fieldInput)) {
            $fileObj = $fieldInput;
        } else {
            if (!Input::hasFile($fieldInput)) {
                return false;
            }

            $fileObj = Input::file($fieldInput);
        }

        if ($fileObj->getClientSize() >= 2000000) {
            return false;
        }

        $extensionExplode = explode('/' , $fileObj->getMimeType()); // getting image extension
        unset($extensionExplode[0]);
        $extensionExplode = array_values($extensionExplode);
        $extension = $extensionExplode[0];

        if (!in_array($extension, ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'PNG', 'gif', 'GIF'])) {
            return false;
        }

        $rand = rand() . date("YmdhisA");
        $fileName = 'mazboot' . '-' . $rand;
        $directory = '';
        $path = public_path() . '/uploads/';

        if ($strAction == 'meals') {
            $directory = $path . 'patients/' . USER_ID . $customPath;
        }

        if ($strAction == 'checkups') {
            $directory = $path . 'patients/' . USER_ID . $customPath;
        }

        $fileName_full = $fileName . '.' . $extension;

        if ($directory == '') {
            return false;
        }

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        if ($fileObj->move($directory, $fileName_full)){
            return $fileName_full;
        }

        return false;
    }

    static function deleteDirectory($dir) {
        system('rm -r ' . escapeshellarg($dir), $retval);
        return $retval == 0; // UNIX commands return zero on success
    }

}