<?php

/**
 * This file is part of the authbucket/oauth2 package.
 *
 * (c) Wong Hoi Sing Edison <hswong3i@pantarei-design.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AuthBucket\OAuth2\TokenType;

use AuthBucket\OAuth2\Exception\ServerErrorException;
use AuthBucket\OAuth2\Model\ModelManagerFactoryInterface;

/**
 * OAuth2 grant type handler factory implemention.
 *
 * @author Wong Hoi Sing Edison <hswong3i@pantarei-design.com>
 */
class TokenTypeHandlerFactory implements TokenTypeHandlerFactoryInterface
{
    protected $modelManagerFactory;
    protected $classes;

    public function __construct(
        ModelManagerFactoryInterface $modelManagerFactory,
        array $classes = array()
    )
    {
        $this->modelManagerFactory = $modelManagerFactory;

        foreach ($classes as $class) {
            if (!class_exists($class)) {
                throw new ServerErrorException(array(
                    'error_description' => 'The token type is not supported by the authorization server.',
                ));
            }

            $reflection = new \ReflectionClass($class);
            if (!$reflection->implementsInterface('AuthBucket\\OAuth2\\TokenType\\TokenTypeHandlerInterface')) {
                throw new ServerErrorException(array(
                    'error_description' => 'The token type is not supported by the authorization server.',
                ));
            }
        }

        $this->classes = $classes;
    }

    public function getTokenTypeHandler($type = null)
    {
        $type = $type ?: current(array_keys($this->classes));

        if (!isset($this->classes[$type]) || !class_exists($this->classes[$type])) {
            throw new ServerErrorException(array(
                'error_description' => 'The token type is not supported by the authorization server.',
            ));
        }

        return new $this->classes[$type](
            $this->modelManagerFactory
        );
    }
}
