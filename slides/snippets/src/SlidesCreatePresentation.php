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

// [START slides_create_presentation]
use Google\Client;
use Google\Service\Drive;
use Google\Service\Slides;
use Google\Service\Slides\Request;

function createPresentation($title)
{
    /* Load pre-authorized user credentials from the environment.
       TODO(developer) - See https://developers.google.com/identity for
        guides on implementing OAuth2 for your application. */
    $client = new Google\Client();
    $client->useApplicationDefaultCredentials();
    $client->addScope(Google\Service\Drive::DRIVE);
    $service = new Google_Service_Slides($client);
    try {
        $presentation = new Google_Service_Slides_Presentation($title);
        //creating a presentation
        $presentation = $service->presentations->create($presentation);
        printf("Created presentation with ID: %s\n", $presentation->presentationId);
        return $presentation;
    } catch (Exception $e) {
        echo 'Message: ' . $e->getMessage();
    }
}

// [END slides_create_presentation]
require 'vendor/autoload.php';
createPresentation("sample presentation");