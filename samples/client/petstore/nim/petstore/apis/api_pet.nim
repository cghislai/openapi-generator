#
# OpenAPI Petstore
# 
# This is a sample server Petstore server. For this sample, you can use the api key `special-key` to test the authorization filters.
# The version of the OpenAPI document: 1.0.0
# 
# Generated by: https://openapi-generator.tech
#

import httpclient
import json
import logging
import marshal
import options
import strformat
import strutils
import tables
import typetraits
import uri

import ../models/model_api_response
import ../models/model_pet

const basepath = "http://petstore.swagger.io/v2"

template constructResult[T](response: Response): untyped =
  if response.code in {Http200, Http201, Http202, Http204, Http206}:
    try:
      when name(stripGenericParams(T.typedesc).typedesc) == name(Table):
        (some(json.to(parseJson(response.body), T.typedesc)), response)
      else:
        (some(marshal.to[T](response.body)), response)
    except JsonParsingError:
      # The server returned a malformed response though the response code is 2XX
      # TODO: need better error handling
      error("JsonParsingError")
      (none(T.typedesc), response)
  else:
    (none(T.typedesc), response)


proc addPet*(httpClient: HttpClient, pet: Pet): (Option[Pet], Response) =
  ## Add a new pet to the store
  httpClient.headers["Content-Type"] = "application/json"

  let response = httpClient.post(basepath & "/pet", $(%pet))
  constructResult[Pet](response)


proc deletePet*(httpClient: HttpClient, petId: int64, apiKey: string, additionalMetadata: string): Response =
  ## Deletes a pet
  httpClient.headers["Content-Type"] = "application/x-www-form-urlencoded"
  httpClient.headers["api_key"] = apiKey
  let query_for_api_call = encodeQuery([
    ("additionalMetadata", $additionalMetadata), # Additional data to pass to server
  ])
  httpClient.delete(basepath & fmt"/pet/{petId}", $query_for_api_call)


proc findPetsByStatus*(httpClient: HttpClient, status: seq[Status]): (Option[seq[Pet]], Response) =
  ## Finds Pets by status
  let query_for_api_call = encodeQuery([
    ("status", $status.join(",")), # Status values that need to be considered for filter
  ])

  let response = httpClient.get(basepath & "/pet/findByStatus" & "?" & query_for_api_call)
  constructResult[seq[Pet]](response)


proc findPetsByTags*(httpClient: HttpClient, tags: seq[string]): (Option[seq[Pet]], Response) {.deprecated.} =
  ## Finds Pets by tags
  let query_for_api_call = encodeQuery([
    ("tags", $tags.join(",")), # Tags to filter by
  ])

  let response = httpClient.get(basepath & "/pet/findByTags" & "?" & query_for_api_call)
  constructResult[seq[Pet]](response)


proc getPetById*(httpClient: HttpClient, petId: int64): (Option[Pet], Response) =
  ## Find pet by ID

  let response = httpClient.get(basepath & fmt"/pet/{petId}")
  constructResult[Pet](response)


proc updatePet*(httpClient: HttpClient, pet: Pet): (Option[Pet], Response) =
  ## Update an existing pet
  httpClient.headers["Content-Type"] = "application/json"

  let response = httpClient.put(basepath & "/pet", $(%pet))
  constructResult[Pet](response)


proc updatePetWithForm*(httpClient: HttpClient, petId: int64, name: string, status: string): Response =
  ## Updates a pet in the store with form data
  httpClient.headers["Content-Type"] = "application/x-www-form-urlencoded"
  let query_for_api_call = encodeQuery([
    ("name", $name), # Updated name of the pet
    ("status", $status), # Updated status of the pet
  ])
  httpClient.post(basepath & fmt"/pet/{petId}", $query_for_api_call)


proc uploadFile*(httpClient: HttpClient, petId: int64, additionalMetadata: string, file: string): (Option[ApiResponse], Response) =
  ## uploads an image
  httpClient.headers["Content-Type"] = "multipart/form-data"
  let query_for_api_call = newMultipartData({
    "additionalMetadata": $additionalMetadata, # Additional data to pass to server
    "file": $file, # file to upload
  })

  let response = httpClient.post(basepath & fmt"/pet/{petId}/uploadImage", multipart=query_for_api_call)
  constructResult[ApiResponse](response)

