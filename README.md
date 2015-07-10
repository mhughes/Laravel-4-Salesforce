  
Laravel 4 Salesforce  with better SSL support 
====================

This Laravel 4 package provides an interface for using [Salesforce CRM](http://www.salesforce.com/) through its SOAP API.

The only changes, allow setting a stream context to the SoapClient for better ssl handling, and flexibility.

Installation
------------

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `davispeixoto/laravel-salesforce`.

```json
    "require": {
        "laravel/framework": "4.*",
        "mhughes/laravel-salesforce": "2.0.*"
    }
```

Next, update Composer from the Terminal:

```sh
    composer update
```

Once this operation completes, still in Terminal run:

```sh
	php artisan config:publish davispeixoto/laravel-salesforce
```

### Configuration

Update the settings in the generated `app/config/packages/davispeixoto/laravel-salesforce` configuration file with your salesforce credentials.

Ensure you put [your WSDL file](https://www.salesforce.com/us/developer/docs/api/Content/sforce_api_quickstart_steps_generate_wsdl.htm) into a proper place and make it readable by your Laravel Application. 

**IMPORTANT:** the PHP Force.com Toolkit for PHP only works with Enterprise WSDL

Finally add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

```php
    'Davispeixoto\LaravelSalesforce\LaravelSalesforceServiceProvider'
```

That's it! You're all set to go. Just use:

```php
    Route::get('/test', function() {
        try {
            echo print_r(Salesforce::describeLayout('Account'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            die($e->getMessage() . $e->getTraceAsString());
        }
    });
```

### More Information

Check out the [SOAP API Salesforce Documentation](http://www.salesforce.com/us/developer/docs/api/index_Left.htm)

### License

This Salesforce Force.com Toolkit for PHP port is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

### Versioning

This project follows the [Semantic Versioning](http://semver.org/)

## Thanks

An amazing "Thank you, guys!" for [Jetbrains](https://www.jetbrains.com/) folks, 
who kindly empower this project with a free open-source license for [PhpStorm](https://www.jetbrains.com/phpstorm/) which can bring a whole new level of joy for coding.

[![Jetbrains][2]][1]

[![PhpStorm][4]][3]

  [1]: https://www.jetbrains.com/
  [2]: https://www.jetbrains.com/company/docs/logo_jetbrains.png
  [3]: https://www.jetbrains.com/phpstorm/
  [4]: https://www.jetbrains.com/phpstorm/documentation/docs/logo_phpstorm.png
