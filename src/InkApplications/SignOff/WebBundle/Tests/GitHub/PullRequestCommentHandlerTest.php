<?php
/*
 * Copyright (c) 2015 Ink Applications, LLC.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace InkApplications\SignOff\WebBundle\Tests\GitHub;

use InkApplications\SignOff\Api\GitHub\StatusEndpoint;
use InkApplications\SignOff\WebBundle\Entity\UserRepository;
use InkApplications\SignOff\WebBundle\GitHub\PullRequestCommentHandler;
use PHPUnit_Framework_TestCase as TestCase;
use Mockery;

class PullRequestCommentHandlerTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * Test to ensure that valid success messages trigger a successful status
     * change and nothing else.
     *
     * @dataProvider validSuccessStrings
     * @test
     */
    public function validSuccess($body)
    {
        $json = self::getJsonObjectFromBody($body);
        $statusEndpoint = Mockery::mock(StatusEndpoint::class);
        $statusEndpoint->shouldReceive('markFailure')->never();
        $statusEndpoint->shouldReceive('markPending')->never();
        $statusEndpoint->shouldReceive('markSuccessful')->once();
        $userRepository = new UserRepository();

        $foo = new PullRequestCommentHandler($statusEndpoint);
        $foo->handle($json, $userRepository);
    }

    /**
     * Comment strings that should be considered acceptable ways to trigger a
     * successful peer review.
     */
    public static function validSuccessStrings()
    {
        return [
            ['+1'],
            ['+1 '],
            [' +1'],
            ['  +1 '],
            ['  +1 Looks good man.'],
            [':+1:'],
            ['lgtm'],
            ['LgTM'],
        ];
    }

    /**
     * Comment strings that should NOT trigger any successful or failure
     * messages because they don't match a valid format.
     *
     * @dataProvider invalidStrings
     * @test
     */
    public function invalid($body)
    {
        $json = self::getJsonObjectFromBody($body);
        $statusEndpoint = Mockery::mock(StatusEndpoint::class);
        $statusEndpoint->shouldReceive('markSuccessful')->never();
        $statusEndpoint->shouldReceive('markPending')->never();
        $statusEndpoint->shouldReceive('markFailure')->never();
        $userRepository = new UserRepository();

        $foo = new PullRequestCommentHandler($statusEndpoint);
        $foo->handle($json, $userRepository);
    }

    public static function invalidStrings()
    {
        return [
            ['This is totally +1'],
            ['1+1=3'],
            ['+1fail'],
            [' '],
            [''],
        ];
    }

    /**
     * Test to ensure that valid failure messages trigger a failure status
     * change and nothing else.
     *
     * @dataProvider validFailureStrings
     * @test
     */
    public function validFailure($body)
    {
        $json = self::getJsonObjectFromBody($body);
        $statusEndpoint = Mockery::mock(StatusEndpoint::class);
        $statusEndpoint->shouldReceive('markFailure')->once();
        $statusEndpoint->shouldReceive('markPending')->never();
        $statusEndpoint->shouldReceive('markSuccessful')->never();
        $userRepository = new UserRepository();

        $foo = new PullRequestCommentHandler($statusEndpoint);
        $foo->handle($json, $userRepository);
    }

    /**
     * Comment strings that should be considered acceptable ways to trigger a
     * failure peer review.
     */
    public static function validFailureStrings()
    {
        return [
            ['-1'],
            ['-1 '],
            [' -1'],
            ['  -1 '],
            ['  -1 this sucks.'],
            [':-1:'],
            ['nopenopenope fuck this shitsville.'],
        ];
    }

    /**
     * Creates A mock comment json object body response.
     */
    private static function getJsonObjectFromBody($body)
    {
        $json = (object) [
            'pull_request' => (object) [
                'head' => (object) [
                    'sha' => 'test-sha-1'
                ]
            ],
            'comment' => (object) [
                'body' => $body
            ]
        ];

        return $json;
    }
}
