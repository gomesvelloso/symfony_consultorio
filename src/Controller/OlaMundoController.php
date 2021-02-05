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

        return new JsonResponse(["mensagem"  => "Olá Mundo, tudo bem?",
                                 "pathInfo"  => $pathInfo,
                                 "parametro" => $parametro,
                                 "todosParametros" => $todosParametros
                                ]);
    }
}