<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\NoticiasRepository;
use App\Entity\Noticias;
use App\Entity\Volunteer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CrudController extends AbstractController
{
    private $em;
    private $newsRepository;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $em, NoticiasRepository $news, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->newsRepository = $news;
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/', name: 'app_init0')]
    public function init(): Response
    {
        $token = $this->tokenStorage->getToken();


        if (null !== $token) {
            return $this->redirectToRoute('app_init');
        } else {
            return $this->redirectToRoute('app_login');
        }
    }


    #[Route('/admin', name: 'app_init')]
    public function initA(): response
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

    #[Route('/newsJson', name: 'todas_json', methods: ['get'])]
    public function getNewsJson(ManagerRegistry $doctrine): JsonResponse
    {
        $news = $doctrine->getRepository(Noticias::class)->findAll();

        $data = [];

        foreach ($news as $new) {
            $data[] = [
                'id' => $new->getId(),
                'title' => $new->getTitle(),
                'start_date' => $new->getStartDate(),
                'description' => $new->getDescription(),
                'image' => $new->getImage(),
                'source' => $new->getSource()
            ];
        }

        return $this->json($data);
    }

    #[Route('/newsJson/{id}', name: 'news_json', methods: ['get'])]
    public function getNewsJsonById(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $new = $doctrine->getRepository(Noticias::class)->find($id);

        if (!$new) {
            return $this->json('No new found for id ' . $id, 404);
        }

        $data = [
            'id' => $new->getId(),
            'title' => $new->getTitle(),
            'start_date' => $new->getStartDate(),
            'description' => $new->getDescription(),
            'image' => $new->getImage(),
            'source' => $new->getSource()
        ];

        return $this->json($data);
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

    #[Route('/angular', name: 'app_angular')]
    public function angular(): RedirectResponse
    {
        return new RedirectResponse('http://localhost:4200');
    }

    #[Route('/accesDenied', name: 'app_denied')]
    public function denied(): RedirectResponse
    {
        return $this->render('error/accesDenied.html.twig', []);
    }

    #[Route('/procesarFormulario', name: 'app_form')]
    public function processForm(Request $request, ManagerRegistry $doctrine): Response
    {

        // Obtener los datos del formulario enviados a través de la solicitud POST
        $nombre = $request->request->get('nombre');
        $apellidos = $request->request->get('apellidos');
        $dni = $request->request->get('dni');
        $pasaporte = $request->request->get('pasaporte');
        $email = $request->request->get('mail');
        $tel = $request->request->get('telf');
        $comentarios = $request->request->get('comentarios');

        // Guardar los datos en un array asociativo
        /* $datosFormulario = [
            'Nombre' => $nombre,
            'Apellidos' => $apellidos,
            'DNI' => $dni,
            'Pasaporte' => $pasaporte,
            'Email' => $email,
            'Teléfono' => $tel,
            'Comentarios' => $comentarios
        ]; */

        $entityManager = $doctrine->getManager();
   
        $volunteer = new Volunteer();
        $volunteer->setNombre($nombre);
        $volunteer->setApellidos($apellidos);
        $volunteer->setDni($dni);
        $volunteer->setPasaporte($pasaporte);
        $volunteer->setEmail($email);
        $volunteer->setTelefono(intval($tel));
        $volunteer->setComentario($comentarios);
        $entityManager->persist($volunteer);
        $entityManager->flush();

        // Mostrar los datos con var_dump()
        /* var_dump($datosFormulario); */


        // También puedes devolver una respuesta para confirmar que los datos han sido recibidos
        return new RedirectResponse('http://localhost:4200/inscripcion');
    }
}
