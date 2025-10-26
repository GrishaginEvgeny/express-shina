<?php

namespace App\Controller;

use App\Factory\Reponse\SuccessResponseFactory;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/api/products')]
class ProductController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository
    ) {

    }

    #[Route('/list/by-type', name: 'api_products_list_by_type', methods: ['GET'])]
    public function list(
        Request $request,
        #[ValueResolver('uuid_resolver')] Uuid $lastUuid = null
    ): JsonResponse {
        $type = $request->get('type');

        return $this->json(
            SuccessResponseFactory::create(
                $this->productRepository->getProductsByType($type, $lastUuid)
            )
        );
    }
}
