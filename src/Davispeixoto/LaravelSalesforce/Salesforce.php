<?php namespace Davispeixoto\LaravelSalesforce;

use Davispeixoto\ForceDotComToolkitForPhp\SforceEnterpriseClient as Client;
use Exception;
use Illuminate\Config\Repository;

/**
 * Class Salesforce
 *
 * Provides an easy binding to Salesforce
 * on Laravel 4 applications through SOAP
 * Data Integration.
 *
 * @package Davispeixoto\LaravelSalesforce
 */
class Salesforce
{

    /**
     * @var \Davispeixoto\ForceDotComToolkitForPhp\SforceEnterpriseClient sfh The Salesforce Handler
     */
    public $sfh;

    private $username;
    private $password;
    private $token;

    /**
     * The constructor.
     *
     * Authenticates into Salesforce according to
     * the provided credentials and WSDL file
     *
     * @param Repository $configExternal
     * @throws SalesforceException
     */
    public function __construct(Repository $configExternal)
    {
        try {
            $this->sfh = new Client();

            $wsdl = $configExternal->get('laravel-salesforce::wsdl');

            if (empty($wsdl)) {
                $wsdl = __DIR__ . '/Wsdl/enterprise.wsdl.xml';
            }

            $soapOptions = [];

            $context = $configExternal->get("laravel-salesforce::stream_context");

            if($context){
                $soapOptions["stream_context"] = stream_context_create($context);
            }

            $this->sfh->createConnection($wsdl,
                                        $configExternal->get("laravel-salesforce::proxy_options"),
                                        $soapOptions
                                        );

            $this->username = $configExternal->get('laravel-salesforce::username');
            $this->password = $configExternal->get('laravel-salesforce::password');
            $this->token = $configExternal->get('laravel-salesforce::token');

        } catch (Exception $e) {
            throw new \Exception('Exception at Constructor' . $e->getMessage() . "\n\n" . $e->getTraceAsString());
        }
    }

    public function __call($method, $args)
    {
        try{
            $login_result = $this->sfh->login($this->username, $this->password . $this->token);
        } catch (Exception $e) {
            throw new \Exception('Exception at Constructor' . $e->getMessage() . "\n\n" . $e->getTraceAsString());
        }
        return call_user_func_array(array($this->sfh, $method), $args);
    }

    /*
     * Debugging functions
     */

    /**
     * @return mixed
     */
    public function dump()
    {
        return print_r($this, true);
    }
}
