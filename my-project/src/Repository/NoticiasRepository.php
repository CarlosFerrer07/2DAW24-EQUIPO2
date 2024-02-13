<?php

namespace App\Repository;

use App\Entity\Noticias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Noticias>
 *
 * @method Noticias|null find($id, $lockMode = null, $lockVersion = null)
 * @method Noticias|null findOneBy(array $criteria, array $orderBy = null)
 * @method Noticias[]    findAll()
 * @method Noticias[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoticiasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Noticias::class);
    }

    public function updateNewR(int $id, Request $request)
    {
        // Obtener el EntityManager
        $entityManager = $this->getEntityManager();

        // Buscar la noticia por ID
        $new = $entityManager->find(Noticias::class, $id);

        // Comprobar si la solicitud es POST y si hay datos en la solicitud
        if ($request->isMethod('POST')) {
            // Llamar a la función separada para manejar la lógica de actualización
            $this->setNewsData($new, $request);

            // Persistir los cambios en la base de datos
            $entityManager->persist($new);
            $entityManager->flush();
        }

        return $new;
    }

    public function createNewR(Request $request)
    {
        // Obtener el EntityManager
        $entityManager = $this->getEntityManager();

        // Crear una nueva instancia de Cliente
        $new = new Noticias();

        if ($request->isMethod('POST')) {
            $this->setNewsData($new, $request);

            // Persistir los cambios en la base de datos
            $entityManager->persist($new);
            $entityManager->flush();

            return $new;
        }

        return null;
    }

    public function deleteNewR(int $id)
    {
        // Obtener el EntityManager
        $entityManager = $this->getEntityManager();

        // Buscar la noticia por ID
        $new = $entityManager->find(Noticias::class, $id);

        // Verificar si la noticia existe
        if ($new) {
            // Eliminar el departamento
            $entityManager->remove($new);

            // Confirmar y aplicar los cambios a la base de datos
            $entityManager->flush();
        }
    }

    public function setNewsData(Noticias $new, Request $request): void
    {
        $new->setTitle($request->request->get('title'));

        // Para la fecha

        // Obtener la fecha de la solicitud
        $dateString = $request->request->get('date');

        // Convertir la cadena de fecha a un objeto DateTime
        $date = new \DateTime($dateString);

        // Establecer la fecha en la entidad
        $new->setStartDate($date);

        $new->setDescription($request->request->get('description'));

        $new->setImage($request->request->get('image'));

        $new->setSource($request->request->get('source'));


    }

    //    /**
    //     * @return Noticias[] Returns an array of Noticias objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Noticias
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
