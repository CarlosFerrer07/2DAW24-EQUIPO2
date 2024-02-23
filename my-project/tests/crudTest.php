<?php
use PHPUnit\Framework\TestCase;
use App\Controller\CrudController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NoticiasRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


final class CrudTest extends TestCase
{
    public function testAngularRedirect(): void
    {
        // Creamos stubs para las dependencias del controlador
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $noticiasRepository = $this->createMock(NoticiasRepository::class);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);

        // Instanciamos el controlador pasándole las dependencias
        $controller = new CrudController($entityManager, $noticiasRepository, $tokenStorage);

        // Llamar al método angular()
        $response = $controller->angular();

        // Verificar si la respuesta es una instancia de RedirectResponse
        $this->assertInstanceOf(RedirectResponse::class, $response);

        // Verificar si la URL de redirección es la correcta
        $this->assertEquals('http://localhost:4200', $response->getTargetUrl());
    }
}
?>

