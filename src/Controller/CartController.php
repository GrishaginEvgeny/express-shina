<?php

namespace App\Controller;

use App\Component\Cart\Session\CartSession;
use App\Component\Cart\Session\CartSessionFactory;
use App\Entity\CartItem;
use App\Facade\Cart\CartManagementFacade;
use App\Factory\Reponse\ErrorResponseFactory;
use App\Factory\Reponse\SuccessResponseFactory;
use App\Helper\AmountCalculatorHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/api/carts')]
class CartController extends AbstractSessionController
{
    public function __construct(
        private readonly CartSessionFactory $sessionFactory,
        private readonly CartManagementFacade $cartManagementFacade,
        RequestStack $requestStack,
    ) {
        parent::__construct($requestStack);
    }

    #[Route('cart/', name: 'api_cart_info', methods: ['GET'])]
    public function getCountItemsByCart(
        #[ValueResolver('uuid_resolver')] Uuid $lastUuid = null
    ): JsonResponse {
        $cartSession = $this->getCartSession();

        if (null === $cartSession) {
            return $this->json(
                ErrorResponseFactory::create(
                    Response::HTTP_BAD_REQUEST,
                    "Не удалось найти корзину"
                ),
                Response::HTTP_BAD_REQUEST
            );
        }

        $batch = $cartSession->getBatch($lastUuid);
        $lastCartItem = end($batch);

        return $this->json(
            SuccessResponseFactory::create([
                'count_all' => $cartSession->getCountItems(),
                'amount_all' => $cartSession->getAmount(),
                'count_per_page' => count($batch),
                'amount_per_page' => AmountCalculatorHelper::calculate($batch),
                'items' => $batch,
                'last_added_at' => $lastCartItem instanceof CartItem ? $lastCartItem->getAddedAt() : null,
            ])
        );
    }

    #[Route('/cart/{productId}', name: 'api_cart_add', methods: ['POST'])]
    public function add(Uuid $productId): JsonResponse
    {
        $cartSession = $this->getCartSession();

        if (null === $cartSession) {
            return $this->json(
                ErrorResponseFactory::create(
                    Response::HTTP_BAD_REQUEST,
                    "Не удалось найти корзину"
                ),
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $cartSession->addById($productId);
        } catch (\Throwable $exception) {
            return $this->json(
                ErrorResponseFactory::create(
                    Response::HTTP_BAD_REQUEST,
                    $exception->getMessage()
                ),
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json(
            SuccessResponseFactory::create('Товар добавлен успешно!')
        );
    }

    #[Route('/cart/{productId}', name: 'api_cart_delete', methods: ['DELETE'])]
    public function remove(Uuid $productId): JsonResponse
    {
        $cartSession = $this->getCartSession();

        if (null === $cartSession) {
            return $this->json(
                ErrorResponseFactory::create(
                    Response::HTTP_BAD_REQUEST,
                    "Не удалось найти корзину"
                ),
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $cartSession->deleteById($productId);
        } catch (\Throwable $exception) {
            return $this->json(
                ErrorResponseFactory::create(
                    Response::HTTP_BAD_REQUEST,
                    $exception->getMessage()
                ),
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json(
            SuccessResponseFactory::create('Товар удалён успешно!')
        );
    }

    private function getCartSession(): ?CartSession
    {
        return $this->sessionFactory->createCartSession(
            $this->cartManagementFacade->getCart($this->getCartKey())
        );
    }
}
