<?php

class Helper
{

    static function formatDate($date, $formate = "Y-m-d H:i:s", $unix = false){
        $date = str_replace("," , '' , $date);
        $FinalDate = $unix != false ? gmdate($formate, $date) : date($formate, strtotime($date));
        return $FinalDate != '1970-01-01 12:00:00' ? $FinalDate : null;
    }

    static function formatDateForDisplay($date, $withTime = false, $dotSeperator = false){
        if($date == null || $date == "0000-00-00 00:00:00" || $date == "0000-00-00"){
            return '';
        }
        $date = $withTime != false ?  date("m/d/Y H:i", strtotime($date)) : date("m/d/Y", strtotime($date));
        return $dotSeperator != false ? str_replace('/', '.', $date) : $date ;
    }

    static function getTimeFromDate($date){
        if($date == null || $date == "0000-00-00 00:00:00" || $date == "0000-00-00"){
            return '';
        }
        return date("H:i", strtotime($date));
    }

    static function displayAddress($address){
        return str_replace(', ', ',<br>', $address);
    }

    static function fixPaginate($url, $key) {
        if(strpos($key , $url) == false){
            $url = preg_replace('/(.*)(?)' . $key . '=[^&]+?(?)[0-9]{0,4}(.*)|[^&]+&(&)(.*)/i', '$1$2$3$4$5$6$7$8$9$10$11$12$13$14$15$16$17$18$19$20', $url . '&');
            $url = substr($url, 0, -1);
            return $url ;
        }else{
            return $url;
        }
    }

    static function calcDistance($distanceByMeter){
        return $distanceByMeter != null ? round($distanceByMeter / 1000 , 1) : 0;
    }
    
    static function calcDuration($durationBySeconds){
        $hours = floor($durationBySeconds / 3600);
        $mins = floor($durationBySeconds / 60 % 60);
        $secs = floor($durationBySeconds % 60);
        
        if($secs < 30){
            $mins = $mins + 1;
        }

        return [(int)$hours, (int)$mins];
    }

    static function calcDurationMinutes($durationBySeconds){
        $mins = floor($durationBySeconds / 60 % 60);
        $secs = floor($durationBySeconds % 60);
        
        if($secs < 30){
            $mins = $mins + 1;
        }

        return (int)$mins;
    }

    Static function GeneratePagination($source){
        $uri = \Input::getUri();
        $count = count($source);
        $total = $source->total();
        $lastPage = $source->lastPage();
        $currentPage = $source->currentPage();

        $data = new \stdClass();
        $data->count = $count;
        $data->total_count = $total;
        $data->current_page = $currentPage;
        $data->last_page = $lastPage;
        $next = $currentPage + 1;
        $prev = $currentPage - 1;

        $newUrl = self::fixPaginate($uri, "page");

        if(preg_match('/(&)/' , $newUrl) != 0 || strpos($newUrl , '?') != false ){
            $separator = '&';
        }else{
            $separator = '?';
        }

        if($currentPage !=  $lastPage ){
            $link = str_replace('&&' , '&' , $newUrl . $separator. "page=". $next);
            $link = str_replace('?&' , '?' , $link);
            $data->next = $link;
            if($currentPage == 1){
                $data->prev = "";
            }else{
                $link = str_replace('&&' , '&' , $newUrl . $separator. "page=". $prev);
                $link = str_replace('?&' , '?' , $link);
                $data->prev = $link ;
            }
        }else{
            $data->next = "";
            if($currentPage == 1){
                $data->prev = "";
            }else{
                $link = str_replace('&&' , '&' , $newUrl . $separator. "page=". $prev);
                $link = str_replace('?&' , '?' , $link);
                $data->prev = $link ;
            }
        }

        return $data;
    }

    static function checkRules($rule){
        if(IS_ADMIN == 1){
            return true;
        }

        $explodeRule = explode(',', $rule);

        /** Sections Rule (array) && User Permission (array) */
        $containsSearch = count(array_intersect($explodeRule, (array) PERMISSIONS)) > 0;
        if($containsSearch == true){
            return true;
        }

        return false;
    }

    static function globalDelete($dataObj) {
         if ($dataObj == null) {
            return response()->json(\TraitsFunc::ErrorMessage('Not Found'));
        }

        $dataObj->deleted_by = USER_ID;
        $dataObj->deleted_at = date('Y-m-d H:i:s');
        $dataObj->save();

        $data['status'] = \TraitsFunc::SuccessResponse("Deleted Successfully");
        return response()->json($data);
    }
}
