<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Entity\Medico;
use App\Helper\EspecialidadeFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadesController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var EspecialidadeFactory
     */
    private $especialidadeFactory;

    public function __construct(EntityManagerInterface $entityManager, EspecialidadeFactory $especialidadeFactory)
    {
        $this->entityManager = $entityManager;
        $this->especialidadeFactory = $especialidadeFactory;
    }

    /**
     * @Route("/especialidades", methods={"POST"})
     */
    public function nova(Request $request): Response
    {
        $dadosRequest  = $request->getContent();
        $especialidade = $this->especialidadeFactory->criarEspecialdiade($dadosRequest);

        $this->entityManager->persist($especialidade);
        $this->entityManager->flush();

        $response = new JsonResponse($especialidade);
    }

    /**
     * @return Response
     * @Route("/especialidades", methods={"GET"})
     */
    public function buscarTodos(): Response
    {
        $respositorioDeEspecialidades = $this
            ->getDoctrine()
            ->getRepository(Especialidade::class);

        $especialidades = $respositorioDeEspecialidades->findBy(array(), array('descricao'=>'ASC'));
        $response = new JsonResponse($especialidades);

        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @param int $id
     * @return Response
     * @Route("/especialidades/{id}", methods={"GET"})
     */
    public function buscarUm (int $id): Response
    {

        $especialiadade = $this->buscarEspecialdiade($id);
        $codigoRestorno = is_null($especialiadade) ? Response::HTTP_NO_CONTENT : 200;
        $lista = array();

        $lista["id"]  = $especialiadade->getId();
        $lista["crm"] = $especialiadade->getDescricao();
        $lista["medicos"] = [];
        foreach($especialiadade->getMedicos() as $m){
            array_push($lista["medicos"], $m);
        }
        $response = new JsonResponse($lista, $codigoRestorno);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Respose
     * @Route("/especialidades/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request): Response
    {
        $dadosRequest = $request->getContent();

        $especialidadeEnviada = $this->especialidadeFactory->criarEspecialdiade($dadosRequest);

        $especialidadeBd = $this->buscarEspecialdiade($id);

        if(is_null($especialidadeBd)){
            return new Response("Especialidade não encontrada para o id $id", Response::HTTP_NO_CONTENT);
        }

        $especialidadeBd->setDescricao($especialidadeEnviada->getDescricao());
        $this->entityManager->flush();

        return new JsonResponse($especialidadeBd);

    }

    /**
     * @param int $id
     * @return Response
     * @Route("/especialidades/{id}", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $especialidade = $this->buscarEspecialdiade($id);
        if(is_null($especialidade)){
            return new Response("Especialidade não encontrada com o id $id", Response::HTTP_NO_CONTENT);
        }
        $this->entityManager->remove($especialidade);
        $this->entityManager->flush();

        return new Response("Especialidade ".$especialidade->getDescricao()." removida com sucesso!", 200);
    }

    /**
     * @param int $id
     * @return Especialidade|object|null
     */
    public function buscarEspecialdiade(int $id)
    {
        $especialidade = new Especialidade();

        $repositorioDesEspecialidades = $this
            ->getDoctrine()
            ->getRepository(Especialidade::class);
        $dados = $repositorioDesEspecialidades->find($id);

        $especialidade->setDescricao($dados->getDescricao());
        $especialidade->setId($dados->getId());

        //Busca os Medicos
        $repMedico = $this->getDoctrine()->getRepository(Medico::class);
        $listaMedicos = $repMedico->findBy(array("especialidade"=>$id), array("nome"=> "ASC"));
        foreach($listaMedicos as $medico){
            $especialidade->addMedico($medico);
        }
        return $especialidade;
    }
}
