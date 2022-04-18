<?php

/**
 * PetController
 * PHP version 7.1.3
 *
 * @category Class
 * @package  OpenAPI\Server\Controller
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */

/**
 * OpenAPI Petstore
 *
 * This is a sample server Petstore server. For this sample, you can use the api key `special-key` to test the authorization filters.
 *
 * The version of the OpenAPI document: 1.0.0
 * 
 * Generated by: https://github.com/openapitools/openapi-generator.git
 *
 */

/**
 * NOTE: This class is auto generated by the openapi generator program.
 * https://github.com/openapitools/openapi-generator
 * Do not edit the class manually.
 */

namespace OpenAPI\Server\Controller;

use \Exception;
use JMS\Serializer\Exception\RuntimeException as SerializerRuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Constraints as Assert;
use OpenAPI\Server\Api\PetApiInterface;
use OpenAPI\Server\Model\ApiResponse;
use OpenAPI\Server\Model\Pet;

/**
 * PetController Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Server\Controller
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */
class PetController extends Controller
{

    /**
     * Operation addPet
     *
     * Add a new pet to the store
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function addPetAction(Request $request)
    {
        // Make sure that the client is providing something that we can consume
        $consumes = ['application/json', 'application/xml'];
        if (!static::isContentTypeAllowed($request, $consumes)) {
            // We can't consume the content that the client is sending us
            return new Response('', 415);
        }

        // Figure out what data format to return to the client
        $produces = ['application/xml', 'application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication
        // Authentication 'petstore_auth' required
        // Oauth required
        $securitypetstore_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables
        $pet = $request->getContent();

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $inputFormat = $request->getMimeType($request->getContentType());
            $pet = $this->deserialize($pet, 'OpenAPI\Server\Model\Pet', $inputFormat);
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("OpenAPI\Server\Model\Pet");
        $asserts[] = new Assert\Valid();
        $response = $this->validate($pet, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'petstore_auth'
            $handler->setpetstore_auth($securitypetstore_auth);

            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->addPet($pet, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 200:
                    $message = 'successful operation';
                    break;
                case 405:
                    $message = 'Invalid input';
                    break;
            }

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Operation deletePet
     *
     * Deletes a pet
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function deletePetAction(Request $request, $petId)
    {
        // Handle authentication
        // Authentication 'petstore_auth' required
        // Oauth required
        $securitypetstore_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables
        $apiKey = $request->headers->get('api_key');
        $additionalMetadata = $request->request->get('additionalMetadata');

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $petId = $this->deserialize($petId, 'int', 'string');
            $apiKey = $this->deserialize($apiKey, 'string', 'string');
            $additionalMetadata = $this->deserialize($additionalMetadata, 'string', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($petId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($apiKey, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($additionalMetadata, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'petstore_auth'
            $handler->setpetstore_auth($securitypetstore_auth);

            // Make the call to the business logic
            $responseCode = 204;
            $responseHeaders = [];
            $result = $handler->deletePet($petId, $apiKey, $additionalMetadata, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 400:
                    $message = 'Invalid pet value';
                    break;
            }

            return new Response(
                '',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Operation findPetsByStatus
     *
     * Finds Pets by status
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function findPetsByStatusAction(Request $request)
    {
        // Figure out what data format to return to the client
        $produces = ['application/xml', 'application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication
        // Authentication 'petstore_auth' required
        // Oauth required
        $securitypetstore_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables
        $status = $request->query->get('status');

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $status = $this->deserialize($status, 'array<csv,string>', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\All([
            new Assert\Choice([ "available", "pending", "sold" ])
        ]);
        $asserts[] = new Assert\All([
            new Assert\Type("string"),
        ]);
        $asserts[] = new Assert\Valid();
        $response = $this->validate($status, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'petstore_auth'
            $handler->setpetstore_auth($securitypetstore_auth);

            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->findPetsByStatus($status, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 200:
                    $message = 'successful operation';
                    break;
                case 400:
                    $message = 'Invalid status value';
                    break;
            }

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Operation findPetsByTags
     *
     * Finds Pets by tags
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     * @deprecated
     */
    public function findPetsByTagsAction(Request $request)
    {
        // Figure out what data format to return to the client
        $produces = ['application/xml', 'application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication
        // Authentication 'petstore_auth' required
        // Oauth required
        $securitypetstore_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables
        $tags = $request->query->get('tags');

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $tags = $this->deserialize($tags, 'array<csv,string>', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\All([
            new Assert\Type("string"),
        ]);
        $asserts[] = new Assert\Valid();
        $response = $this->validate($tags, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'petstore_auth'
            $handler->setpetstore_auth($securitypetstore_auth);

            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->findPetsByTags($tags, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 200:
                    $message = 'successful operation';
                    break;
                case 400:
                    $message = 'Invalid tag value';
                    break;
            }

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Operation getPetById
     *
     * Find pet by ID
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function getPetByIdAction(Request $request, $petId)
    {
        // Figure out what data format to return to the client
        $produces = ['application/xml', 'application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication
        // Authentication 'api_key' required
        // Set key with prefix in header
        $securityapi_key = $request->headers->get('api_key');

        // Read out all input parameter values into variables

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $petId = $this->deserialize($petId, 'int', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($petId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'api_key'
            $handler->setapi_key($securityapi_key);

            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->getPetById($petId, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 200:
                    $message = 'successful operation';
                    break;
                case 400:
                    $message = 'Invalid ID supplied';
                    break;
                case 404:
                    $message = 'Pet not found';
                    break;
            }

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Operation updatePet
     *
     * Update an existing pet
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function updatePetAction(Request $request)
    {
        // Make sure that the client is providing something that we can consume
        $consumes = ['application/json', 'application/xml'];
        if (!static::isContentTypeAllowed($request, $consumes)) {
            // We can't consume the content that the client is sending us
            return new Response('', 415);
        }

        // Figure out what data format to return to the client
        $produces = ['application/xml', 'application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication
        // Authentication 'petstore_auth' required
        // Oauth required
        $securitypetstore_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables
        $pet = $request->getContent();

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $inputFormat = $request->getMimeType($request->getContentType());
            $pet = $this->deserialize($pet, 'OpenAPI\Server\Model\Pet', $inputFormat);
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("OpenAPI\Server\Model\Pet");
        $asserts[] = new Assert\Valid();
        $response = $this->validate($pet, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'petstore_auth'
            $handler->setpetstore_auth($securitypetstore_auth);

            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->updatePet($pet, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 200:
                    $message = 'successful operation';
                    break;
                case 400:
                    $message = 'Invalid ID supplied';
                    break;
                case 404:
                    $message = 'Pet not found';
                    break;
                case 405:
                    $message = 'Validation exception';
                    break;
            }

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Operation updatePetWithForm
     *
     * Updates a pet in the store with form data
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function updatePetWithFormAction(Request $request, $petId)
    {
        // Handle authentication
        // Authentication 'petstore_auth' required
        // Oauth required
        $securitypetstore_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables
        $name = $request->request->get('name');
        $status = $request->request->get('status');

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $petId = $this->deserialize($petId, 'int', 'string');
            $name = $this->deserialize($name, 'string', 'string');
            $status = $this->deserialize($status, 'string', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($petId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($name, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($status, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'petstore_auth'
            $handler->setpetstore_auth($securitypetstore_auth);

            // Make the call to the business logic
            $responseCode = 204;
            $responseHeaders = [];
            $result = $handler->updatePetWithForm($petId, $name, $status, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 405:
                    $message = 'Invalid input';
                    break;
            }

            return new Response(
                '',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Operation uploadFile
     *
     * uploads an image
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function uploadFileAction(Request $request, $petId)
    {
        // Figure out what data format to return to the client
        $produces = ['application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication
        // Authentication 'petstore_auth' required
        // Oauth required
        $securitypetstore_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables
        $additionalMetadata = $request->request->get('additionalMetadata');
        $file = $request->files->get('file');

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $petId = $this->deserialize($petId, 'int', 'string');
            $additionalMetadata = $this->deserialize($additionalMetadata, 'string', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($petId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($additionalMetadata, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\File();
        $response = $this->validate($file, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'petstore_auth'
            $handler->setpetstore_auth($securitypetstore_auth);

            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->uploadFile($petId, $additionalMetadata, $file, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 200:
                    $message = 'successful operation';
                    break;
            }

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Returns the handler for this API controller.
     * @return PetApiInterface
     */
    public function getApiHandler()
    {
        return $this->apiServer->getApiHandler('pet');
    }
}
