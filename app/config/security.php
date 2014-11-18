<?php

/**
 * This file is part of the authbucket/oauth2-php package.
 *
 * (c) Wong Hoi Sing Edison <hswong3i@pantarei-design.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;

$app['security.encoder.digest'] = $app->share(function ($app) {
    return new PlaintextPasswordEncoder();
});

$app['security.user_provider.default'] = $app->share(function ($app) {
    return $app['authbucket_oauth2.model_manager.factory']->getModelManager('user');
});

$app['security.user_provider.admin'] = $app['security.user_provider.inmemory._proto'](array(
    'admin' => array('ROLE_ADMIN', 'secrete'),
));

$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/admin',
        'http' => true,
        'users' => $app['security.user_provider.admin'],
    ),
    'oauth2_login' => array(
        'pattern' => '^/oauth2/login$',
        'anonymous' => true,
    ),
    'oauth2_authorize' => array(
        'pattern' => '^/oauth2/authorize',
        'remember_me' => true,
        'form' => array(
            'login_path' => '/oauth2/login',
            'check_path' => '/oauth2/authorize/login_check',
        ),
        'logout' => array(
            'logout_path' => '/oauth2/authorize/logout',
            'target_url' => '/demo',
        ),
        'users' => $app['security.user_provider.default'],
    ),
    'api_oauth2_authorize' => array(
        'pattern' => '^/api/v1.0/oauth2/authorize$',
        'http' => true,
        'users' => $app['security.user_provider.default'],
    ),
    'api_oauth2_token' => array(
        'pattern' => '^/api/v1.0/oauth2/token$',
        'oauth2_token' => true,
    ),
    'api_oauth2_debug' => array(
        'pattern' => '^/api/v1.0/oauth2/debug$',
        'oauth2_resource' => true,
    ),
    'api' => array(
        'pattern' => '^/api/v1.0',
        'oauth2_resource' => true,
    ),
);
