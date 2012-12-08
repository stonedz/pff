<?php

namespace pff\modules;

/**
 * Module to perform HTTP requests
 *
 * @author paolo.fagni<at>gmail.com
 */
class NetworkHelper extends \pff\Amodule
{


    public function __construct()
    {
    }

    /**
     * Performs a GET request
     *
     * @param string $url Target URL
     * @param int $port Port number
     * @param array|null $headers Optional headers to be passed to the request
     * @return array Request response
     */
    public function doGet($url, $port = 80, $headers = NULL)
    {
        $retarr = array(); // Return value

        $curl_opts = array(CURLOPT_URL => $url,
            CURLOPT_PORT => $port,
            CURLOPT_POST => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true);

        if ($headers) {
            $curl_opts[CURLOPT_HTTPHEADER] = $headers;
        }

        $response = $this->doCurl($curl_opts);

        if (!empty($response)) {
            $retarr = $response;
        }

        return $retarr;
    }

    /**
     * Performs a POST request
     *
     * @param string $url Target URL
     * @param string $postbody POST contents
     * @param int $port Port number
     * @param array|null $headers Optional headers to be passed to the request
     * @return array Request response
     */
    public function doPost($url, $postbody, $port = 80, $headers = NULL)
    {
        $retarr = array(); // Return value

        $curl_opts = array(CURLOPT_URL => $url,
            CURLOPT_PORT => $port,
            CURLOPT_POST => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => $postbody,
            CURLOPT_RETURNTRANSFER => true);

        if ($headers) {
            $curl_opts[CURLOPT_HTTPHEADER] = $headers;
        }

        $response = $this->doCurl($curl_opts);

        if (!empty($response)) {
            $retarr = $response;
        }

        return $retarr;
    }

    /**
     * Curl helper method. Performs a Curl request
     *
     * @param array $curl_opts Curl options array
     * @return array Curl request response
     */
    public function doCurl($curl_opts)
    {
        $retarr = array(); // Return value

        if (!$curl_opts) {
            return $retarr;
        }

        // Open curl session
        $ch = curl_init();
        if (!$ch) {
            return $retarr;
        }

        // Set curl options that were passed in
        curl_setopt_array($ch, $curl_opts);

        // Ensure that we receive full header
        curl_setopt($ch, CURLOPT_HEADER, true);

        // Send the request and get the response
        ob_start();
        $response = curl_exec($ch);
        $curl_spew = ob_get_contents();
        ob_end_clean();

        // Check for errors
        if (curl_errno($ch)) {
            $errno = curl_errno($ch);
            $errmsg = curl_error($ch);

            curl_close($ch);
            unset($ch);
            return $retarr;
        }
        // Get information about the transfer
        $info = curl_getinfo($ch);

        // Parse out header and body
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        // Close curl session
        curl_close($ch);
        unset($ch);
        // Set return value
        array_push($retarr, $info, $header, $body);

        return $retarr;
    }
}
