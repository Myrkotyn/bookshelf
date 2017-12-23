<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Language;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class LanguageApiController
 * @Rest\Route("/languages")
 */
class LanguageApiController extends FOSRestController
{
    /**
     * @Rest\Get("/", name="get_all_languages")
     *
     * @param Request $request
     * @return View
     */
    public function getAllLanguages(Request $request)
    {
        $languages = $this->getDoctrine()->getManager()->getRepository(Language::class)->findAll();

        if (!$languages) {
            throw new NotFoundHttpException('Languages not found!');
        }

        return View::create($this->get('serializer')->normalize($languages, "", ["groups" => ["language"]]), Response::HTTP_OK);
    }
}