<?php

namespace App\Routing\Controllers;
use Symfony\Component\HttpFoundation\Request;

class RedirectController extends BaseController
{
    public function removeTrailingSlash(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);

        return $this->redirect($url);
    }
}