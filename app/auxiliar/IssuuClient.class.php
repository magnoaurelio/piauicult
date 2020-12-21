<?php
/**
 * IssuuClient hooks into Issuu's API
 *
 * example:
 *    include 'IssuuClient.php';
 *    $issuu =  new IssuuClient(pubKey, privKey, apiAdr);
 *    $issuu->openAction('issuu.document.url_upload');
 *    $issuu->slurpUrl = 'pdfurl.pdf';
 *    $issuu->executeAction();
 *    var_dump($issuu->getResponse());
 *    $issuu->closeAction();
 *
 */
class IssuuClient {
  /**
   * Name of the current Action
   *
   * @var string
   */
  protected $_actionName;

  /**
   * prepared data for action
   *
   * @var array prepared data
   */
  protected $_data;

  /**
   * prepared data as http parameter string
   *
   * @var string
   */

  protected $_dataString;

  /**
   * response from issuu of action
   *
   * @var object response
   */
  protected $_response;
  
  /**
   * Public Api Key
   *
   * @var string
   */
   
  protected $_responseType;

  /**
   * Public Api Key
   *
   * @var string
   */
  protected $_publicKey;

  /**
   * Private Api Key
   *
   * @var string
   */
  protected $_privateKey;

  /**
   * Url of issuu api
   *
   * @var string
   */
  protected $_apiAddress;

  /**
   * Class Constructor
   *
   * @param string $publicKey
   * @param string $privateKey
   * @param string $apiAddress
   * @return void
   */
  public function __construct($apiAddress) {
    $this->_publicKey = "w7gaavla35y0wnpwg8fofw8o66t3vmhx"; // Public API key here
    $this->_privateKey = "k3nthcnmpgvf5zd2rcnmzxtuzni0l58o"; // Private API key here
    $this->_apiAddress = $apiAddress;
  }

  /**
   * Opens the action and prepares the required fields
   *
   * @param string $actionName
   * @return void
   * @throws Exception when action template is not aviable
   */
  public function openAction($actionName) {
    $this->closeAction();
    $this->_actionName = $actionName;
    $this->_data = array();
  }

  /**
   * Executes the action
   *
   * @return void
   */
  public function executeAction() {
    $this->prepareData();
    $this->sendData();
  }

  /**
   * Resets the current action all its data
   *
   * @return void
   */
  public function closeAction() {
    $this->_data = null;
    $this->_dataString = null;
    $this->_actionName = null;
    $this->_response = null;
  }

  /**
   * Returns all data from the action as an object
   *
   * @return void
   */
  public function getActionData() {
    $data = new stdClass();
    $data->data = $this->_data;
    $data->dataString = $this->_dataString;
    $data->response = $this->_response;
    $data->name = $this->_actionName;
    return $data->dataString;
  }

  /**
   * Returns the value from an action parameter
   *
   * @param string $key
   * @return mixed
   * @throws Exception when key has not been found
   */
  public function __get($key) {
    if (isset($this->_data[$key])) {
      return $this->_data[$key];
    } else {
      throw new Exception('Value with key ' . $key . ' is not available.');
    }
  }

  /**
   * Sets an value from action parameter
   *
   * @param string $key
   * @param mixed $value
   * @return void
   * @throws Exception when key has not been found
   */
  public function __set($key, $value) {
    $this->_data[$key] = $value;
  }

  /**
   * Returns the response data from issuu action
   *
   * @return object
   */
  public function getResponse() {
    return $this->_response;
  }

  /**
   * Prepares the data for the action
   *
   * @return void
   * @throws Exception when required field has not been set
   */
  protected function prepareData() {
    $this->_data['apiKey'] = $this->_publicKey;
    $this->_data['action'] = $this->_actionName;
    $this->_data['format'] = 'xml';
    $this->_data['responseParams'] = 'title,documentId';

    ksort($this->_data);
    $signature = (string)$this->_privateKey;
    foreach($this->_data as $k => $v){
      $this->_dataString[] = $k . '=' . $v;
      $signature .= $k . $v;
    }
    $data['signature'] = md5($signature);
    $this->_dataString[] = 'signature' . '=' . $data['signature'];
    $this->_dataString = implode('&', $this->_dataString);
    $this->_dataString = preg_replace('{Array}', '', $this->_dataString);
  }

  /**
   * Sends the Action Data to issuu and handles the response
   * @return void
   *
   */
  protected function sendData() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->_apiAddress);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_dataString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $this->prepareReceivedData(curl_exec($ch));
  }

  /**
   * Transforms the issuu xml response to an object
   *
   * @param string $receivedData the received xml string from issuu
   * @return void;
   */
  protected function prepareReceivedData($receivedData) {
    $this->_response = $receivedData;
  }
}
?>