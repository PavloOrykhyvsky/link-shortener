<?php

namespace App\Controller\Web;

use App\Entity\Link;
use App\Entity\Click;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClickController extends AbstractController
{
    public function click(Link $link, Request $request)
    {
        if ($link->isNotActive()) {
            throw new NotFoundHttpException();
        }

        $click = (new Click());
        $click->setIp($request->getClientIp());
        $click->setLink($link);

        $em = $this->getDoctrine()->getManager();
        $em->persist($click);
        $em->flush();

        return $this->redirect($link->getRedirectUrl(), Response::HTTP_MOVED_PERMANENTLY);
    }
}
