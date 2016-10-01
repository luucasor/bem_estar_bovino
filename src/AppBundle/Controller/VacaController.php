<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VacaController extends Controller
{
    /**
     * @Route("/vacas", name="listagem")
     */
    public function listar(Request $request)
    {
        $number = mt_rand(0, 100);
        return new Response('<html><body>Lucky number: '.$number.'</body></html>');
    }
}
