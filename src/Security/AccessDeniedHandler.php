<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private $templating;
    public function __construct(\Twig_Environment $templating)
    {
        $this->templating = $templating;
    }
    
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        return new Response($this->templating->render('login/access-denied.html.twig'));
    }
}
