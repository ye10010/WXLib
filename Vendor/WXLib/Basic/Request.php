<?php
/**
 * @todo $apiOptions should be configed from a config center
 *
 */
namespace WXLib\Basic;
require_once 'Vendor/PEAR/HTTP/Request2.php';
use WXLib\Basic\Token\AccessToken;

class Request extends AbstractRequest
{
    protected $accessToken;
    
    public function setAccessToken($accessToken) 
    {
        $this->accessToken = $accessToken;
        
        return $this;
    }
    
    public function getAccessToken()
    {
        return $this->accessToken;
    }
    
    public function __construct($apiOptions = null)
    {
        parent::__construct($apiOptions);
        if (!isset($apiOptions['accessToken'])) {
            $accessToken = (new AccessToken())->get();
        } else {
            $accessToken = $apiOptions['accessToken'];
        }
        $this->setAccessToken($accessToken);
        if ($this->apiOptions['method'] == \HTTP_Request2::METHOD_GET) {
            $this->getRequest()->getUrl()->setQueryVariable('access_token', $this->getAccessToken());
        }
        if ($this->apiOptions['method'] == \HTTP_Request2::METHOD_POST) {
            $this->request->addPostParameter('access_token', $this->getAccessToken());
        }
        
    }
}
?>