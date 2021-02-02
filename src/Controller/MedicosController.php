<?php


namespace App\Controller;

use App\Entity\Medico;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface  $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/medicos", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();

        $dadosEmJson = json_decode($corpoRequisicao);

        $medico = new Medico();
        $medico->crm  = $dadosEmJson->crm;
        $medico->nome = $dadosEmJson->nome;

        //Ele persiste o médico. Passa a 'observar' o médico como Entidade nova.
        $this->entityManager->persist($medico);
        //realizar varias operacoes com o banco
        $this->entityManager->flush(); //Comando flush salva os dados no banco
        //Vale lembrar que pode ocorrer ero ao inserir pelo fato da tabela ainda não existe na base de dados;
        //Devemos então criar uma migration para criar esta tabela (php bin\console doctrine:migrations:diff)
        //Para rodar a migration, utilizamos o comando no prompt: php bin\console doctrine:migrations:migrate
        return new JsonResponse($medico);
    }

    /**
     * @Route("/medicos", methods={"GET"})
     */
    public function buscarTodos(): Response
    {
        $repositorioDeMedicos = $this
                                ->getDoctrine()
                                ->getRepository(Medico::class);
        $medicoList = $repositorioDeMedicos->findAll();
        return new JsonResponse($medicoList);
    }

    /**
     * @Route ("/medicos/{id}", methods={"GET"})
     */
    public function buscarUm(int $id): Response
    {
        # Aqui não precisamos passar o Request $request no parâmetro pelo fato de,
        # nós só precisarmos do $id para fazer a consulta no banco de dados.
        # Não é necessário buscar nenhum conteúdo (content) além do $id
        $repositorioDeMedicos = $this->getDoctrine()->getRepository(Medico::class);
        $medico = $repositorioDeMedicos->find($id);
        $codigoRetorno = is_null($medico)? Response::HTTP_NO_CONTENT: 200;

        return new JsonResponse($medico, $codigoRetorno);
    }

    /**
     * @param Resquest $request
     * @return Response
     * @Route("/medicos/{id}", methods={"PUT"})
     */
    public function atualizar(int $id, Request $request): Response
    {
        # Diferente do metodo buscarUm, aqui precisamos passar o Request $request no parâmetro pelo fato de,
        # além de buscar o id, eu preciso pegar todos os dados enviado para o update (crm e nome)
        $corpoRequisicao = $request->getContent();
        $dadosEmJson     = json_decode($corpoRequisicao);

        $medicoEnviado = new Medico();
        $medicoEnviado->crm  = $dadosEmJson->crm;
        $medicoEnviado->nome = $dadosEmJson->nome;

        $repsitorioDeMedicos = $this
            ->getDoctrine()
            ->getRepository(Medico::class);
        $medicoExistente = $repsitorioDeMedicos->find($id);

        if(is_null($medicoExistente)){
            # Se não achar o médico na base de dados, retorna vazio com o código de não encontrado.
            return new Response("Médico não encontrado para o id $id", Response::HTTP_NOT_FOUND);
        }

        $medicoExistente->crm  = $medicoEnviado->crm;
        $medicoExistente->nome = $medicoEnviado->nome;

        # $this->entityManager->persist($medicoExistente);
        # O $this->entityManager->persist($medicoExistente);
        # não é necessario pelo fato dele já existir. Ele já está sendo 'observado' pelo Doctrine, por isso
        # comentei a linha.

        $this->entityManager->flush();
        return new JsonResponse($medicoExistente);
    }
}