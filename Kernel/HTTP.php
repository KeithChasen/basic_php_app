<?php

namespace Kernel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\HttpKernel;

class HTTP
{
    /**
     * @param $routes
     * @throws \Exception
     */
    public static function run($routes)
    {
        $matcher = new UrlMatcher($routes, new RequestContext());
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));

        $kernel = new HttpKernel(
            $dispatcher,
            new ControllerResolver(),
            new RequestStack(),
            new ArgumentResolver()
        );

        $request = Request::createFromGlobals();

        $data = json_decode($request->getContent(), true);

        $request->request->replace(is_array($data) ? $data : []);

        $response = $kernel->handle($request);
        $response->send();

        $kernel->terminate($request, $response);
    }

}