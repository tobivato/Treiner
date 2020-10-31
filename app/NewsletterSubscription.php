<?php

declare(strict_types=1);

namespace Treiner;

use Illuminate\Database\Eloquent\Model;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\CreateContact;
use Auth;
use Log;

/**
 * Treiner\NewsletterSubscription
 *
 */
class NewsletterSubscription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'unsub_token',
    ];

    public static function boot() {
        parent::boot();

        /**
         * Creates the same thing in Sendinblue
         */
        self::created(function($model) {
            if (config('app.env') == 'production') {    
                try {
                    $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', config('mail.sendinblue'));
                
                    $apiInstance = new ContactsApi(new \GuzzleHttp\Client(), $config);
    
                    if (Auth::check()) {
                        $listIds = [13];
                        if (Auth::user()->role instanceof Player) {
                            $listIds = [21];
                        }
                        else {
                            $listIds = [25];
                        }
                        $createContact = new CreateContact([
                            'email' => $model->email,
                            'attributes' => [
                                'LASTNAME' => Auth::user()->last_name,
                                'FIRSTNAME' => Auth::user()->first_name,
                                'OTHER_NOTES' => Auth::user()->role_type,
                            ],
                            'listIds' => $listIds
                            ]
                        );
                    }
                    else {
                        $createContact = new CreateContact([
                            'email' => $model->email,
                            'attributes' => [
                                'OTHER_NOTES' => 'Guest',
                            ],
                            'listIds' => [13]
                            ]
                        );
                    }
        
                    $apiInstance->createContact($createContact);
                } catch (\Throwable $th) {
                    Log::info($th);
                }
            }
        });

        /**
         * Deletes self from sendinblue
         */
        self::deleting(function($model){
            if (config('app.env') == 'production') {
                $email = $model->email;
                
                $config = \SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', config('mail.sendinblue'));
                $apiInstance = new \SendinBlue\Client\Api\ContactsApi(new \GuzzleHttp\Client(), $config);
                $apiInstance->deleteContact($email);
            }
        });
    }

    public $incrementing = false;
    protected $primaryKey = 'unsub_token';
}
