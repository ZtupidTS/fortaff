<?php
session_start();




/*       Google Client Login      


/** 
 * Gets an authentication token for a Google service (defaults to
 * Picasa). Puts the token in a session variable and re-uses it as
 * needed, instead of fetching a new token for every call.
 *
 * @static
 * @access public
 * @param string $username Google email account
 * @param string $password Password for Google email account
 * @param string $source name of the calling application (defaults to your_google_app)
 * @param string $service name of the Google service to call (defaults to Picasa)
 * @return boolean|string An authentication token, or false on failure
 */

/*

function googleAuthenticate($username, $password, $source = 'your_google_app', $service = 'lh2') {
    $session_token = $source . '_' . $service . '_auth_token';

    if (@$_SESSION[$session_token]) {
        return $_SESSION[$session_token];
    }

    // get an authorization token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin");
    $post_fields = "accountType=" . urlencode('HOSTED_OR_GOOGLE')
        . "&Email=" . urlencode($username)
        . "&Passwd=" . urlencode($password)
        . "&source=" . urlencode($source)
        . "&service=" . urlencode($service);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    //curl_setopt($ch, CURLINFO_HEADER_OUT, true); // for debugging the request
    //var_dump(curl_getinfo($ch,CURLINFO_HEADER_OUT)); //for debugging the request

    $response = curl_exec($ch);
    curl_close($ch);

    if (strpos($response, '200 OK') === false) {
        echo "<pre>";print_r($response);
        return false;
    }

    // find the auth code
    preg_match("/(Auth=)([\w|-]+)/", $response, $matches);

    if (!$matches[2]) {
        return false;
    }

    $_SESSION[$session_token] = $matches[2];
    return $matches[2];
}



 googleAuthenticate("demotest2323@gmail.com","123admin");

      Google Client Login    END       */


$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

$client = new Google_Client();
$client->setClientId('979996938300.apps.googleusercontent.com');
$client->setClientSecret('D9v49C9HNYFFacOOWEYRDSXc');
$client->setRedirectUri($url);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));
$client->setApprovalPrompt('auto');
$client->setAccessType('offline');
//$client->refreshToken('1/FtotNJphSY1T8M2ss2YmtNS77CkE0rNAAixhcqyizp8');


//if (isset($_GET['code'])) {
//    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
//    header('location:'.$url);exit;
//} elseif (!isset($_SESSION['accessToken'])) {
//    $client->authenticate();
//}

$_SESSION['accessToken'] = $client->getAccessToken();

echo $_SESSION['accessToken'];



//$client->setAccessToken($_SESSION['accessToken']);
 
 
echo "<pre>";print_r($_SESSION);print_r(json_decode($_SESSION['accessToken'],true));






//$files= array();
//$dir = dir('files');
//while ($file = $dir->read()) {
//    if ($file != '.' && $file != '..') {
//        $files[] = $file;
//    }
//}
//$dir->close();

if (!empty($_POST)) {
  
    $client->setAccessToken($_SESSION['accessToken']);
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
  
   
    header('location:'.$url);exit;
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
