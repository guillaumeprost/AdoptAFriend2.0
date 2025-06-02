<?php

namespace App\Twig;

use App\Entity\AdoptionRequest\AdoptionRequest;
use Twig\Extension\AbstractExtension;

class AdoptionRequestExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new \Twig\TwigFunction('status', 'displayStatus'),
        ];
    }

    public function displayStatus(AdoptionRequest $adoptionRequest): string
    {
        switch ($adoptionRequest->getStatus()) {
            case AdoptionRequest::STATUS_NEW:
                echo "i equals 0";
                break;
            case 1:
                echo "i equals 1";
                break;
            case 2:
                echo "i equals 2";
                break;
        }
    }
}
