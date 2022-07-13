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

// [START slides_create_bulleted_text]
use Google\Client;
use Google\Service\Drive;
use Google\Service\Slides;
use Google\Service\Slides\Request;


function createBulletedText($presentationId, $shapeId)
{
    /* Load pre-authorized user credentials from the environment.
       TODO(developer) - See https://developers.google.com/identity for
        guides on implementing OAuth2 for your application. */
    $client = new Google\Client();
    $client->useApplicationDefaultCredentials();
    $client->addScope(Google\Service\Drive::DRIVE);
    $slidesService = new Google_Service_Slides($client);
    // Add arrow-diamond-disc bullets to all text in the shape.
    $requests = array();
    $requests[] = new Google_Service_Slides_Request(array(
        'createParagraphBullets' => array(
            'objectId' => $shapeId,
            'textRange' => array(
                'type' => 'ALL'
            ),
            'bulletPreset' => 'BULLET_ARROW_DIAMOND_DISC'
        )
    ));

    // Execute the request.
    $batchUpdateRequest = new Google_Service_Slides_BatchUpdatePresentationRequest(array(
        'requests' => $requests
    ));
    $response = $slidesService->presentations->batchUpdate($presentationId, $batchUpdateRequest);
    printf("Added bullets to text in shape with ID: %s", $shapeId);
    return $response;
}

// [END slides_create_bulleted_text]
require 'vendor/autoload.php';
createBulletedText('12ZqIbNsOdfGr99FQJi9mQ0zDq-Q9pdf6T3ReVBz0Lms', 'MyTextBox_01');