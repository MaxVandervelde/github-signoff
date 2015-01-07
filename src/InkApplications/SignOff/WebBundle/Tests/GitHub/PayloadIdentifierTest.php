<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\WebBundle\Tests\GitHub;

use InkApplications\SignOff\WebBundle\GitHub\PayloadIdentifier;
use InkApplications\SignOff\WebBundle\GitHub\PayloadType;
use PHPUnit_Framework_TestCase as TestCase;
use stdClass;

class PayloadIdentifierTest extends TestCase
{
    /**
     * Check that the identifier returns the expected types for given json objects.
     *
     * @test
     * @dataProvider payloads
     * @param int|PayloadType $expectedType
     */
    public function testPayload(stdClass $data, $expectedType)
    {
        $identifier = new PayloadIdentifier();
        $actualType = $identifier->getPayloadType($data);

        $this->assertTrue($expectedType == $actualType);
    }

    /**
     * Provides json objects representing GitHub event payloads along with their
     * expected type to be asserted.
     */
    public static function payloads()
    {
        return [
            // Pull Request Comment Payload
            [
                (object) [
                    'pull_request' => (object) [
                        'head' => (object) [
                            'sha' => 'test-sha-1'
                        ]
                    ],
                    'comment' => (object) [
                        'body' => '+1 would use again'
                    ]
                ],
                new PayloadType(PayloadType::PULL_REQUEST_COMMENT)
            ],

            // Pull Request Payload
            [
                (object) [
                    'pull_request' => (object) [
                        'head' => (object) [
                            'sha' => 'test-sha-1'
                        ]
                    ],
                ],
                new PayloadType(PayloadType::PULL_REQUEST)
            ],

            // Pull Request Payload - with constant-cast equality on expected type
            [
                (object) [
                    'pull_request' => (object) [
                        'head' => (object) [
                            'sha' => 'test-sha-1'
                        ]
                    ],
                ],
                PayloadType::PULL_REQUEST
            ],

            // Invalid Request Payload
            [
                (object) [
                    'zen' => 'One does not simply mock zen.'
                ],
                new PayloadType(PayloadType::UNKNOWN)
            ],
        ];
    }
}
