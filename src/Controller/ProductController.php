<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

#[Route('/api/products')]
class ProductController extends AbstractController
{
    // add entityManager to construct for use in all methods
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/load', name: 'product_load', methods:'POST')]
    public function load(Request $request): JsonResponse
    {
        try {

            // convert to array for manipulation
            $data = $request->toArray();

            // in case of errors in json input response 400
            if (!$data) {
                return $this->json(['error' => 'Invalid JSON format.'], 400);
            }

            // iteration in data
            foreach ($data as $productData) {

                // data validation
                $this->validateProductData($productData);                

                // sku validation
                $this->checkUniqueSku($productData['sku']);

                // create new instance of Product
                $product = new Product();
                $product->setSku($productData['sku']);
                $product->setProductName($productData['product_name']);
                $product->setDescription($productData['description']);

                // register object
                $this->entityManager->persist($product);
            }

            // persist changes
            $this->entityManager->flush();

            // response
            return $this->json(['message' => 'Products loaded successfully.']);      
        
        } catch (\Exception $e) {
    
            return $this->json(['error' => $e->getMessage()], 400);
        }
         
    }

    #[Route('/update', name: 'product_update', methods:'PUT')]
    public function update(Request $request): JsonResponse
    {
        try {

            // convert to array for manipulation
            $data = $request->toArray();

            // in case of errors in json input response 400
            if (!$data) {
                return $this->json(['error' => 'Invalid JSON format.'], 400);
            }

            // iteration in data
            foreach ($data as $productData) {
                
                // data validation
                $this->validateProductData($productData);

                // check if product exist
                $product = $this->entityManager->getRepository(Product::class)->findOneBy(['sku' => $productData['sku']]);

                // update existing product
                if ($product) {
                    $product->setProductName($productData['product_name']);
                    $product->setDescription($productData['description']);

                    // register object
                    $this->entityManager->persist($product);
                } else {
                    return $this->json(['error' => 'There is no product with SKU ' . $productData['sku']], 400);
                }
            }

            // persist changes
            $this->entityManager->flush();

            // response
            return $this->json(['message' => 'Products updated successfully.']);

        } catch (\Exception $e) {

            return $this->json(['error' => $e->getMessage()], 400);

        }
    }

    #[Route('/list', name: 'product_list', methods:'GET')]
    public function list(): JsonResponse
    {
        try {
            
            // empty var for store result
            $productList = [];
            
            // get all records
            $products = $this->entityManager->getRepository(Product::class)->findAll();
            
            // iteration about records and create structure of response
            foreach ($products as $product) {
                $productList[] = [
                    'id' => $product->getId(),
                    'sku' => $product->getSku(),
                    'product_name' => $product->getProductName(),
                    'description' => $product->getDescription(),
                    'createdAt' => $product->getCreatedAt()->format('Y-m-d H:i:s'),
                    'updatedAt' => $product->getUpdatedAt()?->format('Y-m-d H:i:s'),
                ];
            }

            // response
            return $this->json($productList);

        } catch (\Exception $e) {

            return $this->json(['error' => $e->getMessage()], 500);

        }
    }

    // --------------------------------- validations -------------------------------- //

    // unique validation
    private function checkUniqueSku(string $sku): void
    {
        // check by sku
        $existingProduct = $this->entityManager->getRepository(Product::class)->findOneBy(['sku' => $sku]);
    
        if ($existingProduct) {
            throw new \InvalidArgumentException("SKU '$sku' already exists. Please use a unique SKU.");
        }
    }

    // fields validation
    private function validateProductData(array $productData): void
    {
        // sku validation
        if (empty($productData['sku']) || strlen($productData['sku']) < 3 || strlen($productData['sku']) > 50) {
            throw new \InvalidArgumentException('Invalid SKU.');
        }
    
        // product_name validation
        if (empty($productData['product_name']) || strlen($productData['product_name']) < 3 || strlen($productData['product_name']) > 250) {
            throw new \InvalidArgumentException('Invalid product_name.');
        }
    }

}
