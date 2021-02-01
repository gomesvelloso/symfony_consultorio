<?php


namespace App\Controller;


use App\Entity\Medico;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController
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
     * @Route("/medicos", methods={"post"})
     */
    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();

        $dadosEmJson = json_decode($corpoRequisicao);

        $medico = new Medico();
        $medico->crm  = $dadosEmJson->crm;
        $medico->nome = $dadosEmJson->nome;

        //Ele persiste o médico. Passa a observar o médico como Entidade nova.
        $this->entityManager->persist($medico);
        //realizar varias operacoes com o banco
        $this->entityManager->flush(); //Comando flush salva os dados no banco
        //Vale lembrar que pode ocorrer ero ao inserir pelo fato da tabela ainda não existe na base de dados;
        //Devemos então criar uma migration para criar esta tabela (php bin\console doctrine:migrations:diff)
        //Para rodar a migration, utilizamos o comando no prompt: php bin\console doctrine:migrations:migrate

        return new JsonResponse($medico);

    }

}