<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MobilePhoneController extends AbstractController
{


    #[Route('/mobilephone/{id}/lowest-price', name: 'lowest-price', methods :'POST')]
    public function lowestPrice(int $id, Request $request): Response
    {

        // dd($id, json_decode($request->getContent(), true));

        if ($request->headers->has('force_fail')) {
            return new JsonResponse([
                'error' => 'Promotions Engine failure message'
            ], $request->headers->get('force_fail'));
        }

        //1. deserialize json data into a EnquiryDTO
        //2. Pass the Enquiry into a promotions filter
            // the appropriate promotion will be applied
        //Return the modify Enquiry


        return new JsonResponse([
            "quantity" => 5,
            "request_location" => "UK",
            "voucher_code" => "OU821",
            "product_id" => $id,
            'price' => 100,
            'discounted_price' >= 50,
            'promotions_id' => 3,
            'promotion_name' => 'Black Friday half price sale '
        ], 200);
    }



    #[Route('/mobilephone/{id}/promotions', name: 'promotions', methods :'GET')]
    public function promotions()
    {

    }
}
