<?php


namespace App\Controller;


use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    /**
     * @Route("/products", name="create_product", methods={"POST"})
     * @param PublisherInterface $publisher
     * @return Response
     */
    public function createProduct(PublisherInterface $publisher): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)

        $productLabel = 'Keyboard';
        $productPrice = 1999;
        $product = $this->createProductFromLabelAndPrice($productLabel, $productPrice);

        $productCreatedMessage = 'Saved new product with id ' . $product->getId();
        // Create the Mercure Update object containing the topic, data
        $update = new Update("https://store.com/product-created", $productCreatedMessage);
        // Publish the Event to Mercure Hub
        $publisher($update);

        return new Response($productCreatedMessage);
    }

    /**
     * @Route("/products", methods={"GET"})
     * @param ProductRepository $productRepository
     */
    public function getAllProducts(ProductRepository $productRepository)
    {
        return $this->json($productRepository->findAll());
    }

    /**
     * @param string $productLabel
     * @param int $productPrice
     * @return Product
     */
    public function createProductFromLabelAndPrice(string $productLabel, int $productPrice): Product
    {
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setLabel($productLabel);
        $product->setPrice($productPrice);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return $product;
    }

}