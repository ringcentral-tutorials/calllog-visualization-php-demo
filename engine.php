<?php
require_once('_bootstrap.php');
use RingCentral\SDK\SDK;
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();


$rcsdk = null;
if (getenv('ENVIRONMENT_MODE') == "sandbox") {
    $rcsdk = new SDK(getenv('CLIENT_ID_SB'),
        getenv('CLIENT_SECRET_SB'), RingCentral\SDK\SDK::SERVER_SANDBOX);
}else{
    $rcsdk = new SDK(getenv('CLIENT_ID_PROD'),
        getenv('CLIENT_SECRET_PROD'), RingCentral\SDK\SDK::SERVER_PRODUCTION);
}
$platform = $rcsdk->platform();

login();
function login(){
    global $platform;
    try {
        if (getenv('ENVIRONMENT_MODE') == "sandbox")
            $platform->login(getenv('USERNAME_SB'), getenv('EXTENSION_SB'), getenv('PASSWORD_SB'));
        else
            $platform->login(getenv('USERNAME_PROD'), getenv('EXTENSION_PROD'), getenv('PASSWORD_PROD'));
        
        readCallLogs();
    }catch (\RingCentral\SDK\Http\ApiException $e) {
        echo($e->getMessage());
    }
}

function readCallLogs() {
  global $platform;
  $endpoint = "";
  if (isset($_REQUEST['access']) && $_REQUEST['access'] == "account")
    $endpoint = '/account/~/call-log';
  else
    $endpoint = '/account/~/extension/~/call-log';
  try {
    $params = json_decode($_REQUEST['params'], true);
    $response = $platform->get($endpoint, $params);
    $json = $response->json();
    echo (json_encode($json->records));
  }catch(\RingCentral\SDK\Http\ApiException $e) {
    $errorMsg = $e->getMessage();
    if (preg_match('/ReadCompanyCallLog/', $errorMsg)){
      $errorRes = '{"calllog_error":"You do not have admin role to access account level. You can choose the extension access level."}';
      echo($errorRes);
    }else{
      $errorRes = '{"calllog_error":"Cannot access call log."}';
      echo($errorRes);
    }
  }
}
