<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\WebBundle\Controller;

use InkApplications\SignOff\WebBundle\Entity\UserRepository;
use InkApplications\SignOff\WebBundle\GitHub\PayloadHandlerFactory;
use InkApplications\SignOff\WebBundle\GitHub\UnhandledPayloadException;
use JMS\DiExtraBundle\Annotation\Inject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class HookController extends Controller
{
    /**
     * @Inject("payload_handler_factory")
     * @var PayloadHandlerFactory
     */
    private $handlerFactory;

    /**
     * @Method("POST")
     * @Route("/repository/{repository}/hook")
     * @Template()
     */
    public function eventAction(Request $request, UserRepository $repository)
    {
        $json = json_decode($request->getContent());

        try {
            $payloadHandler = $this->handlerFactory->getHandler($json);
            $payloadHandler->handle($json, $repository);
        } catch (UnhandledPayloadException $exception) {
            throw new BadRequestHttpException('Invalid Payload Provided.');
        }

        return new Response(null, 204);
    }
}
