<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utils\ApiTagInterativa;
use AppBundle\Model\Vaca;

class VacaController extends Controller
{

    private $dao;

    public function __construct(){
      $this->dao = new ApiTagInterativa();
    }
    /**
     * @Route("/vacas", name="listagem")
     */
    public function listar(Request $request)
    {
        $vacas = $this->dao->listaVacas();
        return $this->render('vacas/listagem.html.twig', array('vacas' => $vacas));
    }

    /**
     * @Route("/vacas/remove/{id}", name="remover")
     */
    public function remover($id)
    {
        $this->dao->removeVaca($id);
        return $this->redirectToRoute('listagem');
    }

    /**
     * @Route("/vacas/nova", name="nova")
     */
    public function nova(Request $request)
    {
        return $this->render('vacas/formulario.html.twig');
    }

    /**
     * @Route("/vacas/adiciona", name="adiciona")
     */
    public function adiciona(Request $request)
    {

        $vaca = new Vaca($request->get('weight'), $request->get('age'), $request->get('price'));

        $this->dao->adicionaVaca($vaca);
        return $this->redirectToRoute('listagem');
    }
}
