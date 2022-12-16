<?php
// config for Asciisd/Zoho

return [
    /*
    |--------------------------------------------------------------------------
    | Client ID
    |--------------------------------------------------------------------------
    |
    | Zoho's Client id for OAuth process
    |
    */
    'client_id' => env('ZOHO_CLIENT_ID', null),

    /*
    |--------------------------------------------------------------------------
    | Client Secret
    |--------------------------------------------------------------------------
    |
    | Zoho's Client secret for OAuth process
    |
    */
    'client_secret' => env('ZOHO_CLIENT_SECRET', null),

    /*
    |--------------------------------------------------------------------------
    | Self Signed Token
    |--------------------------------------------------------------------------
    |
    | Zoho's token for OAuth process
    |
    */
    'token' => env('ZOHO_TOKEN', null),

    /*
    |--------------------------------------------------------------------------
    | REDIRECT URI
    |--------------------------------------------------------------------------
    |
    | this is were we should handle the OAuth tokens after registering your
    | Zoho client
    |
    */
    'redirect_uri' => env('ZOHO_REDIRECT_URI', null),

    /*
    |--------------------------------------------------------------------------
    | CURRENT USER EMAIL
    |--------------------------------------------------------------------------
    |
    | Zoho's email address that will be used to interact with API
    |
    */
    'current_user_email' => env('ZOHO_CURRENT_USER_EMAIL', null),

    /*
    |--------------------------------------------------------------------------
    | LOG FILE PATH
    |--------------------------------------------------------------------------
    |
    | The SDK stores the log information in a file. you can change the path but
    | just make sure to create an empty file with name `ZCRMClientLibrary.log`
    | then point to the folder contains it in config file here
    |
    | note: In case the path is not specified, the log file will be created
    | inside the project.
    |
    */
    'application_log_file_path' => storage_path('app/zoho/oauth/logs/ZCRMClientLibrary.log'),

    /*
    |--------------------------------------------------------------------------
    | Token Persistence Path
    |--------------------------------------------------------------------------
    |
    | path of your tokens text file, this path is predefined and used by default,
    | and you are free to change this path, but just make sure that you generate
    | file with name `zcrm_oauthtokens.txt` then point to the folder that containing
    | the file here
    |
    */
    'token_persistence_path' => storage_path('app/zoho/oauth/tokens/zcrm_oauthtokens.txt'),

    /*
    |--------------------------------------------------------------------------
    | Resource Path
    |--------------------------------------------------------------------------
    |
    | The path containing the absolute directory path to store user specific files
    | containing module fields information.
    |
    */
    'resourcePath' => storage_path('app/zoho'),

    /*
    |--------------------------------------------------------------------------
    | ZOHO Environment
    |--------------------------------------------------------------------------
    |
    | which is of the pattern Domain.Environment
    | Available Domains: USDataCenter, EUDataCenter, INDataCenter, CNDataCenter, AUDataCenter
    | Available Environments: PRODUCTION, DEVELOPER, SANDBOX
    |
    */
    'environment' => env('ZOHO_SANDBOX', false),

    /*
    |--------------------------------------------------------------------------
    | Zoho Path
    |--------------------------------------------------------------------------
    |
    | This is the base URI path where Zoho's views, such as the callback
    | verification screen, will be available from. You're free to tweak
    | this path according to your preferences and application design.
    |
    */
    'path' => env('ZOHO_PATH', 'zoho'),

    /*
    |--------------------------------------------------------------------------
    | Zoho Path
    |--------------------------------------------------------------------------
    |
    | This is the base URI path where Zoho's views, such as the callback
    | verification screen, will be available from. You're free to tweak
    | this path according to your preferences and application design.
    |
    */
    'oauth_scope' => env('ZOHO_OAUTH_SCOPE', 'aaaserver.profile.READ,ZohoCRM.modules.ALL,ZohoCRM.settings.ALL'),

    /*
    |--------------------------------------------------------------------------
    | Auto Refresh Fields (default value is false)
    |--------------------------------------------------------------------------
    |
    | true - all the modules' fields will be auto-refreshed in the background, every hour.
    | false - the fields will not be auto-refreshed in the background. The user can manually delete the file(s) or refresh the fields using methods from ModuleFieldsHandler(com\zoho\crm\api\util\ModuleFieldsHandler)
    |
    */
    'autoRefreshFields' => false,

    /*
    |--------------------------------------------------------------------------
    | Pick List Validation (default value is true)
    |--------------------------------------------------------------------------
    |
    | A boolean field that validates user input for a pick list field and allows or disallows the addition of a new value to the list.
    | true - the SDK validates the input. If the value does not exist in the pick list, the SDK throws an error.
    | false - the SDK does not validate the input and makes the API request with the user’s input to the pick list
    |
    */
    'pickListValidation' => false,

    /*
    |--------------------------------------------------------------------------
    | Enable SSL Verification (default value is true)
    |--------------------------------------------------------------------------
    |
    | A boolean field to enable or disable curl certificate verification
    | true - the SDK verifies the authenticity of certificate
    | false - the SDK skips the verification
    |
    */
    'enableSSLVerification' => true,

    /*
    |--------------------------------------------------------------------------
    | Connection Timeout
    |--------------------------------------------------------------------------
    |
    | The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
    |
    */
    'connectionTimeout' => 3,

    /*
    |--------------------------------------------------------------------------
    | Timeout
    |--------------------------------------------------------------------------
    |
    | The maximum number of seconds to allow cURL functions to execute.
    |
    */
    'timeout' => 10,
];
