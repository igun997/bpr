<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Global_Helper{

    public static $ci_instance;
    public static $mongo_instance;
    public static $slugify_instance;

    public static function getCIInstance(){

        if(!self::$ci_instance){

            self::$ci_instance = &get_instance();
        }

        return self::$ci_instance;
    }

    public static function getMongoInstance(){

        if(!self::$mongo_instance){

            $CI = self::getCIInstance();

            self::$mongo_instance = new Mongo_db([]);
        }

        return self::$mongo_instance;
    }

    public static function isObjectEmpty(object $object_data, String $key, $useless_param = NULL): bool{

        if(property_exists($object_data, $key)){

            if(is_numeric($object_data->$key)){

                return FALSE;
            }
            if(is_bool($object_data->$key)){

                return FALSE;
            }
            return empty($object_data->$key);
        }

        return TRUE;
    }

    public static function customJsonResponse($response, $httpCode = 200){

        $CI = self::getCIInstance();

        $CI->output->set_status_header($httpCode)
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public static function returnResponse($httpCode, $data = NULL, $message = NULL, $pagination_data = NULL, $time_range = NULL, $httpCodeHeader = 200){

        $CI = self::getCIInstance();

        $CI->lang->load('response', $CI->config->item('language'));

        $response = [];

        switch ($httpCode){
            case 200:
                $response['code'] = 200;
                (empty($message)) ? $response['message'] = ($CI->lang->line('response_200')) ? $CI->lang->line('response_200') : 'OK' : $response['message'] = $message;
                break;
            case 202:
                $response['code'] = 202;
                (empty($message)) ? $response['message'] = ($CI->lang->line('response_202')) ? $CI->lang->line('response_202') :  'Accepted' : $response['message'] = $message;
                break;
            case 211:
                $response['code'] = 211;
                (empty($message)) ? $response['message'] = ($CI->lang->line('response_211')) ? $CI->lang->line('response_211') :  'Email verification needed' : $response['message'] = $message;
                break;
            case 212:
                $response['code'] = 212;
                (empty($message)) ? $response['message'] = ($CI->lang->line('response_212')) ? $CI->lang->line('response_212') :  'Two factor authentication needed' : $response['message'] = $message;
                break;
            case 400:
                $response['code'] = 400;
                (empty($message)) ? $response['message'] = ($CI->lang->line('response_400')) ? $CI->lang->line('response_400') :  "Bad Request" : $response['message'] = $message;
                break;
            case 401:
                $response['code'] = 401;
                (empty($message)) ? $response['message'] = ($CI->lang->line('response_401')) ? $CI->lang->line('response_401') :  "Invalid Parameter" : $response['message'] = $message;
                break;
            case 403:
                $response['code'] = 403;
                (empty($message)) ? $response['message'] = ($CI->lang->line('response_403')) ? $CI->lang->line('response_403') :  "Invalid Login Data" : $response['message'] = $message;
                break;
            case 404:
                $response['code'] = 404;
                (empty($message)) ? $response['message'] = ($CI->lang->line('response_404')) ? $CI->lang->line('response_404') :  "No Data" : $response['message'] = $message;
                break;
            case 409:
                $response['code'] = 409;
                (empty($message)) ? $response['message'] = ($CI->lang->line('response_409')) ? $CI->lang->line('response_409') :  "Duplicate Data Found" : $response['message'] = $message;
                break;
            case 422:
                $response['code'] = 422;
                (empty($message)) ? $response['message'] = ($CI->lang->line('response_422')) ? $CI->lang->line('response_422') :  "Invalid Parameter" : $response['message'] = $message;
                break;
            case 500:
                $response['code'] = 500;
                (empty($message)) ? $response['message'] = ($CI->lang->line('response_500')) ? $CI->lang->line('response_500') :  "System Error" : $response['message'] = $message;
                break;
            case 301:
                return $CI->response(($CI->lang->line('response_301')) ? $CI->lang->line('response_301') : "Moved Permanently", 301);
                break;
            default:
                $response['code'] = $httpCode;
                (empty($message)) ? $response['message'] = "" : $response['message'] = $message;
                (empty($data)) ? $response['data'] = [] : $response['data'] = $data;
                break;
        }

        if( ! empty($data)){
            $response['data'] = $data;
        }

        if( ! empty($pagination_data)){
            $response['pagination'] = $pagination_data;
        }

        if( ! empty($time_range)){
            $response['time_range'] = $time_range;
        }

        $CI->output
            ->set_status_header($httpCodeHeader)
            ->set_content_type('application/json')
            ->_display(json_encode($response));
        die();
    }

    public static function isValidDate(String $date){

        $dt = DateTime::createFromFormat("Y-m-d", $date);
        return $dt !== false && !array_sum($dt::getLastErrors());
    }

    public static function isValidTime(String $time){

        $dt = DateTime::createFromFormat("Y-m-d H:i", date('Y-m-d') . " {$time}");
        return $dt !== false && !array_sum($dt::getLastErrors());
    }

    public static function validationErrorChild(array $err, string $injected_key){
        $CI = self::getCIInstance();

        $CI->load->helper('indie/validation');

        if(Validation_Helper::isAssoc($err)){
            foreach($err as $k=>$e){
                unset($err[$k]);
                $err["$injected_key.$k"] = $e;
            }

            return $err;
        }

        return FALSE;
    }

    /**
     * Associative safe
     * Method ini berguna untuk menggabungkan assoc dengan key yang dibutuhkan.
     * jika key tidak ada di dalam assoc, maka otomatis dibuat dengan value null
     *
     * @param array $arr Associative Array.
     * @param array $required_keys Required Key (sequential array).
     * @param bool $value_to_string Will convert value to string if its integer / boolean. default is false.
     *
     * @return false|array
     */
    public static function assocTypeSafe(array $assoc, array $required_keys, bool $value_to_string = FALSE){
        $CI = self::getCIInstance();

        $CI->load->helper('indie/validation');

        if(Validation_Helper::isAssoc($assoc)){
            if(! Validation_Helper::isAssoc($required_keys)){
                foreach($required_keys as $k=>$rk){
                    if(array_key_exists($rk, $assoc)){
                        if($value_to_string){
                            $required_keys[$rk] =  (is_bool($assoc[$rk]) || is_int($assoc[$rk])) ? var_export($assoc[$rk], TRUE) : $assoc[$rk];
                        }
                        else{
                            $required_keys[$rk] =  $assoc[$rk];
                        }
                    }
                    else{
                        $required_keys[$rk] = NULL;
                    }
                    unset($required_keys[$k]);
                }

                return $required_keys;
            }
        }

        return FALSE;
    }

    public static function allowMethod($method, &$param=[], $is_json = FALSE): void{

        $CI = self::getCIInstance();

        $CI->lang->load('response', $CI->config->item('language'));

        if($CI->input->method(TRUE) == $method){

            if(($method == 'PUT') || ($method == 'DELETE')){
                $CI->load->helper('indie/validation');

                //cek si param ada isinya dan itu key? (bukan assoc)
                if($param && is_array($param) && Validation_Helper::isAssoc($param) === FALSE){
                    //parse ke var
                    parse_str(file_get_contents("php://input"), $tmp_param);

                    //build assoc sesuai key yang telah diberikan
                    $param = self::assocTypeSafe($tmp_param, $param);
                }
                else{
                    parse_str(file_get_contents("php://input"), $param);
                }
            }
            return;
        }else{

            $CI->output
                ->set_content_type('application/json')
                ->_display(json_encode([
                    "code" => 405,
                    "message" => ($CI->lang->line('response_405')) ? $CI->lang->line('response_405') : "Method not Allowed"
                ]));
            die();
        }
    }

    public static function randomNumber(int $length, String $pad = '0'){

        return str_pad(rand(0, pow(10, $length)-1), $length, $pad, STR_PAD_LEFT);
    }

    public static function createID(): String{

        return time() . str_pad(rand(0, pow(10, 5)-1), 5, '0', STR_PAD_LEFT);
    }

    public static function setAssetUrl(?String $asset, bool $set_default = TRUE): ?String{

        $ci = self::getCIInstance();

        if($asset){

            $asset = (filter_var($asset, FILTER_VALIDATE_URL)) ? $asset : $ci->config->item('cdn_url') . $asset;
        }else{

            if($set_default){

                $asset = $ci->config->item('cdn_url') . $ci->config->item('default_image');
            }
        }

        return $asset;
    }

    public static function thirdPartyApiConfig($apiName){

        $CI = self::getCIInstance();

        $db_name = (ENVIRONMENT == 'production') ? 'indiemarketfest' : 'indiemarketfest_dev';
        $CI->db->db_select($db_name);

        $options = $CI->db->select("api_third_party_environment.options")
            ->from("api_third_party_environment")
            ->join("api_third_party", "api_third_party.id = api_third_party_environment.api_third_party_id")
            ->where("api_third_party.api_name", $apiName)
            ->where("is_default", 1)
            ->get()->row_array();

        if($options){

            return json_decode($options["options"]);
        }

        return NULL;
    }

    public static function reportSentry(Exception $error, Array $datas = NULL): void{

        if($datas){

            Sentry\configureScope(function (Sentry\State\Scope $scope) use ($datas): void {
                $scope->setExtra('Error Data', $datas);
            });
        }

        Sentry\captureException($error);
    }

    /**
     * Force sentry to sent report / event now
     * Method ini berguna untuk long process (ex: worker)
     * karena secara default, si sentry ngirim report ketika dia destruct
     * jadi kalo ga di force, report nya ga akan ke kirim
     *
     * @return void
     */
    public static function sentryForceReport():void{
        $client = \Sentry\SentrySdk::getCurrentHub()->getClient();

        if ($client instanceof \Sentry\FlushableClientInterface) {
            $client->flush();
        }
    }

    /**
     * Build Tree from Array of Object
     *
     * @param array $items Array of Object.
     * @param string $id (Optional) ID for item.
     * @param string $parent_id (Optional) ID for parent.
     *
     * @return array Array of tree items
     */
    public static function buildTree(Array $items, String $id = 'id', String $parent_id = 'parent_id'){
        $childs = [];

        foreach ($items as $item) {
            $childs[$item->$parent_id ?? 0][] = $item;
        }

        foreach ($items as $item) {
            if (isset($childs[$item->$id])) {
                $item->childs = $childs[$item->$id];
            }
        }

        return $childs[0] ?? [];
    }

    public static function rabbitMQCreateQueue(String $queue_name, Array $message, bool $is_passive = FALSE, bool $is_durable = FALSE, bool $is_exclusive = FALSE, bool $is_auto_delete = FALSE, bool $is_nowait = FALSE): bool{
        if(! (class_exists('PhpAmqpLib\Message\AMQPMessage') && class_exists('PhpAmqpLib\Connection\AMQPStreamConnection'))){
            self::returnResponse(500, NULL, 'Please install "php-amqplib/php-amqplib"');
        }

        $ci = self::getCIInstance();

        $connection = new AMQPStreamConnection($ci->config->item('rabbitmq_host'), $ci->config->item('rabbitmq_port'), $ci->config->item('rabbitmq_user'), $ci->config->item('rabbitmq_pwd'));
        $channel = $connection->channel();

        $channel->queue_declare($queue_name, $is_passive, $is_durable, $is_exclusive, $is_auto_delete, $is_nowait);

        $msg = new AMQPMessage(json_encode($message));
        $channel->basic_publish($msg, '', $queue_name);

        $channel->close();
        $connection->close();

        return TRUE;
    }

    /**
     * Phone number validation
     * Please use from Validation_Helper instead
     *
     * @param string $phone_number Phone Number.
     * @param string $type (Optional) all, mobile or fixed. Default is all.
     *
     * @return false|string standarized phone number
     */
    public static function phoneNumberValidity(String $phone_number, String $type = 'all'){
        $ci = self::getCIInstance();

        $ci->load->helper('indie/validation');
        return Validation_Helper::isValidPhoneNumber($phone_number, $type);
    }

    /**
     * Get category childs upto 2 level
     *
     * @param int $category_id Category ID.
     *
     * @return array
     */
    public static function getCategoryChilds(Int $category_id): array{
        $ci = Global_Helper::getCIInstance();

        $child_ids = [];

        $ci->load->model('Category_Model', 'category_model');

        $lv_1 = $ci->category_model->withParentId($category_id)->find();

        if($lv_1 && is_array($lv_1)){
            $child_ids = array_column($lv_1, 'product_category_id');

            $lv2 = $ci->category_model->withParentId($child_ids)->find();

            if($lv2 && is_array($lv2)){
                $child_ids = array_merge($child_ids, array_column($lv2, 'product_category_id'));
            }
        }

        return $child_ids;
    }

    /**
     * Filter array of string contain string.
     * contoh kasus: dipake di additional ouputs
     *
     * @param array $arr Array of String.
     * @param string $str needle.
     *
     * @return array
     */
    public static function filterArray(array $arr, string $str, $is_reverse = FALSE): array{
        $list = [];
        if($is_reverse){
            foreach($arr as $a){
                if(stripos($a, $str) === FALSE){
                    $list[] = $a;
                }
            }
        }
        else{
            foreach($arr as $a){
                if(stripos($a, $str) !== FALSE){
                    $list[] = str_replace($str, '', $a);
                }
            }
        }

        return $list;
    }

    public static function slugify(String $str): string{
        if(!self::$slugify_instance){
            self::$slugify_instance = new Cocur\Slugify\Slugify();
        }

        return self::$slugify_instance->slugify($str);
    }

    public static function logger($data){
        if(php_sapi_name() !== 'cli'){
            Global_Helper::returnResponse(400, NULL, 'Only for CLI');
        }

        $now = date("F j, Y, H:i:s");
        $type = gettype($data);

        switch($type){
            case "string":
                echo "$data - [$now]" . PHP_EOL;
                break;
            default:
                echo "[!] Logger: unhandled type data ($type) - [$now]" . PHP_EOL;
                exit;
        }
    }

    public static function randomString($lenght = 16) {

        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return strtoupper(substr(bin2hex($bytes), 0, $lenght));
    }
}
