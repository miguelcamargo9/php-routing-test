<?php
namespace Tests;

use App\Route;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    use TestRequestFactory;

    private Route $router;

    protected function setUp(): void
    {
        $this->router = (new Route(debug: true))
            ->resource('patients')
            ->resource('patients.metrics');
    }

    #[Test]
    public function it_resolves_nested_get_route(): void
    {
        $res = $this->router->resolve(
            $this->request('GET', '/patients/2/metrics/abc')
        );

        $this->assertSame(200, $res->getStatusCode());
        $this->assertStringContainsString(
            'metric abc for patient 2',
            (string) $res->getBody()
        );
    }
}
