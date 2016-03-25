<?php

return [

    /*
     * Log emails receiver email.
     * This can also be an array to send to multiple receivers :)
     * [
     *   'example@example.com',
     *   'exaple2@example2.com'
     * ]
     */
    'email_to' => explode(',', env('DEV_EMAIL')),

    /*
     * From email.
     * 
     * (default value: log-envelop@your-domain.com)
     */
    'email_from' => env('MAIL_ADDRESS'),

    /*
     * Decide wether it should queue the e-mails
     *
     */
    'should_queue' => false,

    /*
     * Decide where to log to
     *
     * Options: mail, database or both
     */
    'log_to' => 'mail',

    /*
     * The name of the sender.
     * 
     * (default value: Log Envelope)
     */

    'email_from_name' => 'NetsocAdmin [ERROR]',


    /*
     * How many lines to show near exception line.
     */
    'lines_count' => 12,

    /*
     * List of exceptions to skip sending.
     */
    'except' => [
        //'Symfony\Component\HttpKernel\Exception\NotFoundHttpException',
    ],

];
