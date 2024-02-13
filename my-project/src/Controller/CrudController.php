<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\NoticiasRepository;
use App\Entity\Noticias;

class CrudController extends AbstractController
{
    private $em;
    private $newsRepository;


    public function __construct(EntityManagerInterface $em, NoticiasRepository $news)
    {
        $this->em = $em;
        $this->newsRepository = $news;
    }


    #[Route('/', name: 'app_init')]
    public function init(): response
    {
        $welcome = 'PANEL DE CONTROL';

        return $this->render('index.html.twig', [
            'welcome' => $welcome
        ]);
    }

    #[Route('/noticias/{page?}', name: 'app_news')]
    public function showNews(?int $page = 1): Response
    {

        $news = $this->em->getRepository(Noticias::class)->findAll();

        return $this->render('news/news.html.twig', [
            'news' => $news,
            'page' => $page
        ]);
    }

    #[Route('/detailNew/{id}', name: 'detail_new')]
    public function detailNew(int $id): Response
    {

        $new = $this->em->getRepository(Noticias::class)->find($id);

        if (!$new) {
            return new Response('Unfortunately there is no notice with id: ' . $id);
        }

        return $this->render('news/detailNew.html.twig', [
            'new' => $new,
        ]);
    }

    #[Route('/updateNew/{id}', name: 'update_new')]
    public function updateNew(int $id, Request $request): response
    {

        //llamo a updateNewR que tiene toda la logica de actualización
        $new = $this->newsRepository->updateNewR($id, $request);

        //renderizo
        return $this->render('news/updateNew.html.twig', [
            'new' => $new,
        ]);
    }


    #[Route('/insert', name: 'app_insert')]
    public function insert(Request $request): Response
    {

        // Llamo a createNewR que tiene toda la lógica de inserción
        $this->newsRepository->createNewR($request);

        // Verificar si la solicitud es POST
        if ($request->isMethod('POST')) {
            // Redirigir al listado de clientes si la creación fue exitosa
            return $this->redirectToRoute('app_news');
        }

        // Renderizar el formulario de inserción
        return $this->render('news/insertNew.html.twig');
    }

    #[Route('/deleteNew/{id}', name: 'delete_news')]
    public function delete(int $id): Response
    {
        //llamar a news repository y borramos
        $this->newsRepository->deleteNewR($id);

        //redirigimos a ruta una vez borrado
        return $this->redirectToRoute('app_news');
    }
}