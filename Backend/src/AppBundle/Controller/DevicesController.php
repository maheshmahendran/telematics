<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Device;
use AppBundle\Representation\Devices;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Exception\ApiProblemException;
use AppBundle\Model\ApiProblem;

/**
 * @Route("/devices")
 */
class DevicesController extends FOSRestController
{
    /**
     * @Rest\Get(path="", name="devices_get")
     *
     * @Rest\View(serializerGroups={"default", "succinct_relationships"})
     *
     * @Rest\QueryParam(
     *      name="deviceId",
     *      nullable=true,
     *      description="Filter by Device ID"
     * )
     *
     * @Rest\QueryParam(
     *      name="order_by",
     *      description="Order by"
     * )
     *
     * @Rest\QueryParam(
     *      name="order_direction",
     *      default="ASC",
     *      description="Order direction (ascending or descending)"
     * )
     *
     * @Rest\QueryParam(
     *      name="limit",
     *      requirements="\d+",
     *      default="25",
     *      description="Max number of results"
     * )
     *
     * @Rest\QueryParam(
     *      name="page",
     *      requirements="\d+",
     *      default="1",
     *      description="The page"
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retrieve all device records",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=Device::class, groups={"default"})
     *     )
     * )
     * @SWG\Tag(name="Devices")
     */
    public function getListAction(ParamFetcherInterface $paramFetcher)
    {
        $filter['deviceId'] = $paramFetcher->get('deviceId');

        $orderBy = $paramFetcher->get('order_by');
        $orderDirection = $paramFetcher->get('order_direction');

        if (empty($orderDirection) || strtoupper($orderDirection) != 'DESC') {
            $orderDirection = 'ASC';
        }

        $limit = (empty($paramFetcher->get('limit'))) ? 25 : $paramFetcher->get('limit');
        $page = (empty($paramFetcher->get('page'))) ? 1 : $paramFetcher->get('page');

        $repo = $this->getDoctrine()->getRepository(Device::class);

        $query = $repo->filter($filter, $orderBy, $orderDirection);

        return new Devices($query, $repo->getCount(), $limit, $page);
    }

    /**
     * @Rest\Post(path="", name="device_post")
     *
     * @ParamConverter(
     *      "device",
     *      converter="fos_rest.request_body",
     *      options={
     *          "validator"={
     *              "groups"="device_post"
     *          }
     *      }
     * )
     *
     */
    public function postAction(
        Device $device,
        ConstraintViolationListInterface $violations
    ) {
        if (count($violations)) {
            throw new ApiProblemException(
                new ApiProblem(
                    Response::HTTP_BAD_REQUEST,
                    $violations,
                    ApiProblem::TYPE_VALIDATION_ERROR
                )
            );
        }

        return $this->view($this->get('device_service')->createDevice($device), Response::HTTP_CREATED);
    }
}