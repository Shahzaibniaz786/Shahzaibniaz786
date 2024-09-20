<?php

namespace App\Helpers;
use App\Models\User;
use App\Models\persons\Agent;
use App\Models\Accounts\CashAccounts;
use App\Models\Clients\ClientsFollowUp;
use App\Models\Clients\FollowUpCategory;
use App\Models\Clients\FollowUpSubCategory;

class Helper {

    public static function helperfunction1(){
        return "helper function 1 response";
    }
    
    public static function prevent_multi_submit(){
        return true;
    }

    public static function get_Client_follow_up($id){
        $client_follow_up_data = ClientsFollowUp::where('client_id',$id)->orderBy('id','desc')->first();
        return $client_follow_up_data;
    }
    
    public static function get_sub_category_name($id=0){
        $category = FollowUpSubCategory::find($id);

        return $category;
    }
    
    

    public static function getUserName($id=0){
        $user = User::find($id);

        return $user->name ?? '';
    }

    public static function getCashAccountName($account_id){
        // echo $account_id;
        // die;
        $account_data =  \DB::table('cash_accounts')->where('id',$account_id)->first();

        // $account_data = CashAccounts::find($account_id)->select('account_name','account_number')->first();

        // print_r($account_data);
        return $account_data ?? '';
    }

    public static function getAmountInWords(float $number) {
   
        $hyphen      = '-';
        $conjunction = '  ';
        $separator   = ' ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'Zero',
            1                   => 'One',
            2                   => 'Two',
            3                   => 'Three',
            4                   => 'Four',
            5                   => 'Five',
            6                   => 'Six',
            7                   => 'Seven',
            8                   => 'Eight',
            9                   => 'Nine',
            10                  => 'Ten',
            11                  => 'Eleven',
            12                  => 'Twelve',
            13                  => 'Thirteen',
            14                  => 'Fourteen',
            15                  => 'Fifteen',
            16                  => 'Sixteen',
            17                  => 'Seventeen',
            18                  => 'Eighteen',
            19                  => 'Nineteen',
            20                  => 'Twenty',
            30                  => 'Thirty',
            40                  => 'Fourty',
            50                  => 'Fifty',
            60                  => 'Sixty',
            70                  => 'Seventy',
            80                  => 'Eighty',
            90                  => 'Ninety',
            100                 => 'Hundred',
            1000                => 'Thousand',
            1000000             => 'Million',
            1000000000          => 'Billion',
            1000000000000       => 'Trillion',
            1000000000000000    => 'Quadrillion',
            1000000000000000000 => 'Quintillion'
        );
       
        if (!is_numeric($number)) {
            return false;
        }
       
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }
    
        if ($number < 0) {
            return $negative . Helper::getAmountInWords(abs($number));
        }
       
        $string = $fraction = null;
       
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
       
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . Helper::getAmountInWords($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = Helper::getAmountInWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= Helper::getAmountInWords($remainder);
                }
                break;
        }
       
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
       
        return $string;
    }
    
    public static function check_user_rights($value,$agent_id){
         $user = User::where('id',$agent_id)->first();
        
        $user_rights = json_decode($user->user_rights);
        // echo "hepler is call now ";
        // print_r($user_rights);
        // die;
        if(isset($user_rights)){
            
            foreach($user_rights as $right_res){
            if($value == $right_res){
                echo "checked";
            }
        }
        }
        // $result = array_search($value,$user_rights,true);
        // if($result){
        //     echo "checked";
        // }
    }
    
    public static function get_agent_data($agent_id){
        $agent_data = Agent::find($agent_id);
        return $agent_data;
    }
    
    public static function check_post_rights(){
        $user_rights = \Auth::user()->user_rights;
        
        $user_role = \Auth::user()->role;

        if($user_role == 'admin'){
            return true;
        }else{
            $user_rights = json_decode($user_rights);
            $result = array_search('Files_post',$user_rights,true);
            if($result){
                return true;
            }else{
                return false;
            }
        }
    }
    
    
}