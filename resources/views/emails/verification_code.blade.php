<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Verify Your Email Address</h2>

        <div>
            Just to make sure you're from a college we service, we need you to give the below link a click.<br/>
            <a href="<?php echo $url = URL::route('after-validation', [ 'email' => $email, 'token' => $confirmation_code ]); ?>"><?php echo $url; ?></a><br/>

        </div>

    </body>
</html>