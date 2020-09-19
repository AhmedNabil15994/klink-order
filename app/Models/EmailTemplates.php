<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplates extends Model
{	
	protected $table = 'email_templates';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function parse($data)
    {
        $layout = json_decode($this->layout, true)[\App::getLocale()];
        $subject = json_decode($this->subject, true)[\App::getLocale()];
        $data['AbsoluteSiteUrl'] = url('/');
        $data['YearOfNow'] = date('y');
        $EmailBody = preg_replace_callback('/({{|\[)(.*)(}}|\])/U', function ($matches) use ($data) {
            list($shortCode, $shortCodeTwo, $index) = $matches;
            
            if (isset($data[$index])) {
                return $data[$index];
            } else {
                if ($shortCodeTwo=='{{') {
                    // echo($index);
                }
                return $shortCode;
            }
        }, $layout);
        $EmailSubject = preg_replace_callback('/({{|\[)(.*)(}}|\])/U', function ($matches) use ($data) {
            list($shortCode, $shortCodeTwo, $index) = $matches;

            if (isset($data[$index])) {
                return $data[$index];
            } else {
                return $shortCode;
            }
        }, $subject);
        return [$EmailSubject,$EmailBody];
    }

}
