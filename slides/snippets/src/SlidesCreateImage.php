<?php
/**
 * Copyright 2022 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// [START slides_create_image]
use Google\Client;
use Google\Service\Drive;
use Google\Service\Slides;
use Google\Service\Slides\Request;


function createImage($presentationId, $pageId)
{
    /* Load pre-authorized user credentials from the environment.
    TODO(developer) - See https://developers.google.com/identity for
        guides on implementing OAuth2 for your application. */
    $client = new Google\Client();
    $client->useApplicationDefaultCredentials();
    $client->addScope(Google\Service\Drive::DRIVE);
    $slidesService = new Google_Service_Slides($client);

    try {

        $imageUrl = 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png';
        // Create a new image, using the supplied object ID, with content downloaded from imageUrl.
        $imageId = 'MyImage_01asdfsadfasdf';
        $emu4M = array('magnitude' => 4000000, 'unit' => 'EMU');
        $requests[] = new Google_Service_Slides_Request(array(
            'createImage' => array(
                'objectId' => $imageId,
                'url' => $imageUrl,
                'elementProperties' => array(
                    'pageObjectId' => $pageId,
                    'size' => array(
                        'height' => $emu4M,
                        'width' => $emu4M
                    ),
                    'transform' => array(
                        'scaleX' => 1,
                        'scaleY' => 1,
                        'translateX' => 100000,
                        'translateY' => 100000,
                        'unit' => 'EMU'
                    )
                )
            )
        ));

        // Execute the request.
        $batchUpdateRequest = new Google_Service_Slides_BatchUpdatePresentationRequest(array(
            'requests' => $requests
        ));
        $response = $slidesService->presentations->batchUpdate($presentationId, $batchUpdateRequest);
        $createImageResponse = $response->getReplies()[0]->getCreateImage();
        printf("Created image with ID: %s\n", $createImageResponse->getObjectId());

        return $response;
    } catch (Exception $e) {
        echo 'Message: ' . $e->getMessage();
    }
}

// [END slides_create_image]
require 'vendor/autoload.php';
createImage('12ZqIbNsOdfGr99FQJi9mQ0zDq-Q9pdf6T3ReVBz0Lms', 'abcd1234');