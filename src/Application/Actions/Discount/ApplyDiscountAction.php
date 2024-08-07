<?php

declare(strict_types=1);

namespace App\Application\Actions\Discount;

use Psr\Http\Message\ResponseInterface as Response;

class ApplyDiscountAction extends DiscountAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->getFormData();
        if (empty($data)) {
            return $this->respondWithData(
                [
                    'message' => 'No data provided.',
                ],
                400,
            );
        }

        // TODO: implement order validation.

        $discounts = $this->orderService->getOrderDiscounts($data);

        if (empty($discounts)) {
            return $this->respondWithData(
                [
                    'message' => 'No discounts applied.',
                ],
                204,
            );
        }

        return $this->respondWithData($discounts);
    }
}
