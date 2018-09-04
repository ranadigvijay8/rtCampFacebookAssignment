<?php
    use Facebook\FacebookRequest;
    use Facebook\FacebookResponse;
    use Facebook\FacebookApp;
session_start();
require_once 'Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '221982878480421', // Replace {app-id} with your app id
  'app_secret' => 'c8e24b5e89b1e0901574897190ff5e72',
  'default_graph_version' => 'v3.1',
  ]);

$helper = $fb->getRedirectLoginHelper();
if (isset($_GET['state'])) {
	$helper->getPersistentDataHandler()->set('state',$_GET['state']);
}

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in
//echo '<h3>Access Token</h3>';
//var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//echo '<h3>Metadata</h3>';
//var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('221982878480421'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
    exit;
  }

  //echo '<h3>Long-lived</h3>';
  //var_dump($accessToken->getValue());
}

$response = $fb->get("/me?fields=id, first_name, last_name, email", $accessToken);
$userData = $response->getGraphNode()->asArray();
$_SESSION['userInfo'] = $userData;
$_SESSION['fb_access_token'] = (string) $accessToken;
//echo $userData['albums'];

//==========Fetch Profile Picture
try {
  // Returns a `FacebookFacebookResponse` object
  $response = $fb->get('/me?fields=picture.type(large)',$accessToken);
} catch(FacebookExceptionsFacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(FacebookExceptionsFacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$graphNode = $response->getGraphNode();
$dp=$graphNode['picture']['url'];
$_SESSION['dpurl']=$dp;
$tempToken="EAAEWC7pYlG4BACmz2oSPa2gbl6GZAqh0PbZCjTfZCQYFXV2jP8BmPWkf6HEzOaE2oE2bsAPzvyQZCFmZBZBcxl4vHZCqRhf4EQsnymq6XcEOZBYbqJ7gLhzufTkr12ZBh1MnqA1hJCeRYgkZAW1z3XU2szv7ZB7ZBGpVtlNOWs1mwk55kBusFqkFYvlQXQlFLVP3RPwZD";
//===Albums
//$_SESSION['photos']="https://graph.facebook.com/v3.1/me/photos?fields=link&access_token=".$tempToken."";
$_SESSION['photos'] = $fb->get("/me/photos?fields=picture", $accessToken)->getGraphEdge()->asArray();
//=======================
header('Location:info.php');

exit();
?>