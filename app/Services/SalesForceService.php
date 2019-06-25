<?php

namespace App\Services;


class SalesForceService extends BasicService
{
    /**
     * @param $xml
     * @return null
     */
    protected function checkError($xml)
    {
        $error = $xml->children('soapenv', true)
            ->Body
            ->children('soapenv', true)
            ->Fault
            ->children()
            ->faultstring;

        return $error ? $error->__toString() : null;
    }

    /**
     * @param $xml
     * @return null
     */
    protected function getSessionId($xml)
    {
        $sessionId = $xml->children('soapenv', true)
            ->Body
            ->children()
            ->loginResponse
            ->result
            ->sessionId;

        return $sessionId ? $sessionId->__toString() : null;
    }

    /**
     * @return array
     */
    public function login()
    {
        $response = $this->performLogin();

        if (!$response)
            return $this->sfResponse(false, null, 'Unexpected CURL error');

        $xml = simplexml_load_string($response);

        $soapError = $this->checkError($xml);

        if ($soapError)
            return $this->sfResponse(false, null, $soapError);

        $sessionId = $this->getSessionId($xml);

        if ($sessionId)
            return $this->sfResponse(true, $sessionId,'success');

        return $this->sfResponse(false, null, 'No session id in response');

    }

    /**
     * Format response
     *
     * @param $ok
     * @param $sessionId
     * @param $message
     * @return array
     */
    protected function sfResponse($ok, $sessionId, $message)
    {
        return [
            'ok' => $ok,
            'session_id' => $sessionId,
            'message' => $message
        ];
    }

    /**
     * @return bool|string
     */
    protected function performLogin()
    {
        $domain = getenv('SALESFORCE_OAUTH_DOMAIN');
        $loginUrl = getenv('SALESFORCE_LOGIN_URL');
        $username = getenv('SALESFORCE_USER');
        $password = getenv('SALESFORCE_PASS');
        $token = getenv('SALESFORCE_TOKEN');

        $url = $domain . $loginUrl;

        if (!filter_var($url, FILTER_VALIDATE_URL))
        {
            return false;
        }

        $curlInit = curl_init($url);

        $headers = [
            'Content-Type: text/xml',
            'SOAPAction: Required'
        ];

        $postFields = "
            <se:Envelope xmlns:se='http://schemas.xmlsoap.org/soap/envelope/'>
                <se:Header/>
                <se:Body>
                    <login xmlns='urn:partner.soap.sforce.com'>
                        <username>{$username}</username>
                        <password>{$password}{$token}</password>
                    </login>
                </se:Body>
            </se:Envelope>
        ";

        curl_setopt($curlInit, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curlInit, CURLOPT_POST, 1);
        curl_setopt($curlInit, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curlInit);

        curl_close($curlInit);
        return $response;
    }

    public function group($id)
    {
        $domain = getenv('SALESFORCE_REST_DOMAIN');
        $groupUrl = getenv('SALESFORCE_GROUP_URL');

        $token = $this->login();

        $url = $domain . $groupUrl . $id;

        if (!filter_var($url, FILTER_VALIDATE_URL) || !$token['ok'] || !$token['session_id'])
        {
            return false;
        }

        $curlInit = curl_init($url);

        $headers = [
            'Content-Type: application/json',
            "Authorization: Bearer {$token['session_id']}"
        ];

        curl_setopt($curlInit, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curlInit);

        curl_close($curlInit);

        return $response;
    }

}