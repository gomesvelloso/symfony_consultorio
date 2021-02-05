<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OlaMundoController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function olaMundoAction(Request $request): Response
    {
        //Se eu quiser saber qual foi a url q fez a requisicao
        $pathInfo  = $request->getPathInfo();
        //Se quiser buscar somente um parametro
        $parametro = $request->query->get("tic");
        //Se quiser buscar todos os parametros de uma vez.
        $todosParametros = $request->query->all();
        $html = '<div style="width: 99%; height: 25%; padding:5px; margin-bottom: 40px">
                    <div style="margin-top: 60px">
                        <ul>
                            <li><a style="font-weight: bold; outline: none; color: #000; text-decoration: none" href="/">Home</a></li> 
                            <li><a style="font-weight: bold; outline: none; color: #000; text-decoration: none" href="/medicos">Médicos</a></li></ul>
                        </div>
                        <hr>
                 </div>';
        return new Response($html);
    }
}