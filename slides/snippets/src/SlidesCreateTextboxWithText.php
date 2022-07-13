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

// [START slides_create_textbox_with_text]
use Google\Client;
use Google\Service\Slides\BatchUpdatePresentationRequest;
use Google\Service\Slides;
use Google\Service\DriveFile;
use Google\Service\Slides\Request;

function createTextboxWithText($presentationId, $pageId)
{

    /* Load pre-authorized user credentials from the environment.
       TODO(developer) - See https://developers.google.com/identity for
        guides on implementing OAuth2 for your application. */
    $client = new Google\Client();
    $client->useApplicationDefaultCredentials();
    $client->addScope(Google\Service\Drive::DRIVE);
    $slidesService = new Google_Service_Slides($client);
    try {

        // Create a new square textbox, using the supplied element ID.
        $elementId = "MyTextBoxxxx_01";
        $pt350 = array('magnitude' => 350, 'unit' => 'PT');
        $requests = array();
        $requests[] = new Google_Service_Slides_Request(array(
            'createShape' => array(
                'objectId' => $elementId,
                'shapeType' => 'TEXT_BOX',
                'elementProperties' => array(
                    'pageObjectId' => $pageId,
                    'size' => array(
                        'height' => $pt350,
                        'width' => $pt350
                    ),
                    'transform' => array(
                        'scaleX' => 1,
                        'scaleY' => 1,
                        'translateX' => 350,
                        'translateY' => 100,
                        'unit' => 'PT'
                    )
                )
            )
        ));

        // Insert text into the box, using the supplied element ID.
        $requests[] = new Google_Service_Slides_Request(array(
            'insertText' => array(
                'objectId' => $elementId,
                'insertionIndex' => 0,
                'text' => 'New Box Text Inserted!'
            )
        ));

        // Execute the requests.
        $batchUpdateRequest = new Google_Service_Slides_BatchUpdatePresentationRequest(array(
            'requests' => $requests
        ));
        $response = $slidesService->presentations->batchUpdate($presentationId, $batchUpdateRequest);
        $createShapeResponse = $response->getReplies()[0]->getCreateShape();
        printf("Created textbox with ID: %s\n", $createShapeResponse->getObjectId());
        return $response;
    } catch (Exception $e) {
        echo 'Message: ' . $e->getMessage();
    }
}

// [END slides_create_textbox_with_text]
require 'vendor/autoload.php';
createTextboxWithText('12ZqIbNsOdfGr99FQJi9mQ0zDq-Q9pdf6T3ReVBz0Lms', 'abcd1234');