<?php
session_start();
$url_array = explode('?', 'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
$url = $url_array[0];

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

$client = new Google_Client();
//$client->setClientId('979996938300.apps.googleusercontent.com');
//$client->setClientSecret('HNYFFacOOWEYRDSXc');


$client->setClientId('449354131456.apps.googleusercontent.com');
$client->setClientSecret('5r2E63D5SvPj4ZAkyGm2VsMk');
$client->setRedirectUri($url);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));
$client->setAccessType('offline');

//$refreshToken = "1\/lO57EYYEKvnPkeL1HxJeQ8QiD01KkE0BN3MZ8LNIM_U";
//$refreshToken="4/cTyz-hQLPklAYwc3TK-AQx6UJoc4.wobx_0UjJpMYgrKXntQAax167Ml8fwI";

if ($refreshToken)
    {
        $client->setApprovalPrompt('auto');
        $client->refreshToken($refreshToken);
        
        $_SESSION['accessToken'] = $client->getAccessToken();
    
    }
    else
    {
        
            $client->setApprovalPrompt('force');            
            if (isset($_GET['code'])) {
                
                    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
                    //print_r($_SESSION['accessToken']);
                    //die;
                    
                header('location:' . $url);
                exit;
            } elseif (!isset($_SESSION['accessToken'])) {                
                $client->authenticate();
                echo "<pre>";
                echo $_SESSION['accessToken'];
                print_r(json_decode($_SESSION['accessToken'], true));
                die;
                 //// Save Refresh Token To DB
                
                        
                //        {"access_token":"ya29.AHES6ZQHCYcAiAzguHBAK2QFhADmxruc_4L0EkwHT0lzy56DijekaA","token_type":"Bearer","expires_in":3600,"refresh_token":"1\/FtotNJphSY1T8M2ss2YmtNS77CkE0rNAAixhcqyizp8","created":1373282367}
                //
                
                //Array
                //(
                //    [access_token] => ya29.AHES6ZQHCYcAiAzguHBAK2QFhADmxruc_4L0EkwHT0lzy56DijekaA
                //    [token_type] => Bearer
                //    [expires_in] => 3600
                //    [refresh_token] => 1/FtotNJphSY1T8M2ss2YmtNS77CkE0rNAAixhcqyizp8
                //    [created] => 1373282367
                //)
                
                
            }else{
                    echo "<pre>";
                     $google_usr_info=json_decode($_SESSION['accessToken'], true);
                    print_r($google_usr_info);
            }
    }
//$files= array();
//$dir = dir('files');
//while ($file = $dir->read()) {
//    if ($file != '.' && $file != '..') {
//        $files[] = $file;
//    }
//}
//$dir->close();

if (!empty($_POST)) {

    //echo $_SESSION['accessToken'];
    echo $client->setAccessToken($_SESSION['accessToken']);
    
    $service = new Google_DriveService($client);


//    $finfo = finfo_open(FILEINFO_MIME_TYPE);
//    $file = new Google_DriveFile();
//   
//    foreach ($files as $file_name) {
//        $file_path = 'files/'.$file_name;
//        $mime_type = finfo_file($finfo, $file_path);
//        $file->setTitle($file_name);
//        $file->setDescription('This is a '.$mime_type.' document');
//        $file->setMimeType($mime_type);
//        $service->files->insert(
//            $file,
//            array(
//                'data' => file_get_contents($file_path),
//                'mimeType' => $mime_type
//            )
//        );
//    }
//   
//    finfo_close($finfo);
//  $retriveApp = retrieveAllApps($service);
    // var_dump($retriveApp);


    $file_list = retrieveAllFiles($service);
    echo "<pre>";
    print_r($file_list);
    exit;
    header('location:' . $url);
    exit;
}

function retrieveAllApps($service) {
    try {
        $apps = $service->apps->listApps();
        return $apps->getItems();
    } catch (Exception $e) {
        print "An error occurred: " . $e->getMessage();
    }
    return NULL;
}

function retrieveAllFiles($service) {
    $result = array();
    $pageToken = NULL;

    do {
        try {
            $parameters = array();
            if ($pageToken) {
                $parameters['pageToken'] = $pageToken;
            }
            $parameters['q'] = "trashed = false and mimeType = 'application/vnd.google-apps.folder'";

            $files = $service->files->listFiles($parameters);


            $result = array_merge($result, $files->getItems());
            $pageToken = $files->getNextPageToken();
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
            $pageToken = NULL;
        }
    } while ($pageToken);
    return $result;
}
include 'index.phtml';
