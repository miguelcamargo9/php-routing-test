<?php
declare(strict_types=1);

namespace App;

use App\Exceptions\NotFoundException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Throwable;
use function call_user_func_array;

/**
* Minimal PSR-7 / PSR-15 compatible router for the coding exercise.
*  – Stateless instance
*  – Controller convention (PatientsController, PatientsMetricsController, …)
*  – Supports GET/POST/PATCH/DELETE with nested routes 0-2 levels deep
*/
final class Route
{
    /** @var string[] */
    private array $resources = [];
    private LoggerInterface $log;
    private bool $debug;

    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
        $this->log   = Logger::create();
    }

    public function resource(string $name): self
    {
        $this->resources[] = $name;
        return $this;
    }

    public function resolve(ServerRequestInterface $request): ResponseInterface
    {
        try {
            [$routeKey, $params] = $this->match($request);
            $content             = $this->dispatch($request->getMethod(), $routeKey, $params);
        } catch (NotFoundException $e) {
            return $this->textResponse($e->getMessage(), 404);
        } catch (Throwable $e) {
            $this->log->error($e->getMessage(), ['exception' => $e]);
            $body = $this->debug ? $e->getMessage() . "\n" . $e->getTraceAsString()
                : '500 Internal Server Error';
            return $this->textResponse($body, 500);
        }

        return $this->textResponse($content);
    }

    /** @return array{0:string,1:array<string,string>} */
    private function match(ServerRequestInterface $request): array
    {
        $path = trim($request->getUri()->getPath(), '/');

        /**  patients / {id?} / {subResource?} / {subId?}  */
        $regex = '~^
            (?P<resource>[a-z]+)
            (?:/(?P<id>[0-9]+))?
            (?:/(?P<subResource>[a-z]+)
                (?:/(?P<subId>[a-z0-9\-]+))?
            )?
        $~xi';

        if (!preg_match($regex, $path, $m)) {
            throw new NotFoundException('404 Not Found');
        }

        $routeKey = $m['resource'];
        if (!empty($m['subResource'])) {
            $routeKey .= '.' . $m['subResource'];
        }

        if (!in_array($routeKey, $this->resources, true)) {
            throw new NotFoundException('404 Not Found');
        }

        return [$routeKey, [
            'id'     => $m['id']        ?? null,
            'subId'  => $m['subId']     ?? null,
            'hasSub' => !empty($m['subResource']),
        ]];
    }

    /**
     * @param string $verb ?:?string, subId?:?string, hasSub:bool } $p
     * @param string $route
     * @param array $p
     * @return string
     */
    private function dispatch(string $verb, string $route, array $p): string
    {
        // Controller
        [$resource, $nested] = array_pad(explode('.', $route, 2), 2, null);
        $class  = 'App\\Controllers\\' . ucfirst($resource) . ($nested ? ucfirst($nested) : '') . 'Controller';

        if (!class_exists($class)) {
            throw new NotFoundException('404 Controller Not Found');
        }
        $controller = new $class();

        // Method
        $method = $this->controllerMethod($verb, $p['id'], $p['hasSub'], $p['subId']);
        if (!method_exists($controller, $method)) {
            throw new NotFoundException('404 Method Not Found');
        }

        // Parameters
        $args = array_filter([
            isset($p['id'])    ? (int) $p['id'] : null,
            isset($p['subId']) ? (is_numeric($p['subId']) ? (int) $p['subId'] : $p['subId']) : null,
        ], static fn($v) => $v !== null);

        return (string) call_user_func_array([$controller, $method], $args);
    }

    private function controllerMethod(string $verb, ?string $id, bool $hasSub, ?string $subId): string
    {
        return match ($verb) {
            'GET'    => $subId ? 'get' : ($hasSub ? 'index' : ($id ? 'get' : 'index')),
            'POST'   => 'create',
            'PATCH'  => 'update',
            'DELETE' => 'delete',
            default  => 'index',
        };
    }

    private function textResponse(string $body, int $status = 200): ResponseInterface
    {
        $factory = new Psr17Factory();
        return $factory->createResponse($status)
            ->withHeader('Content-Type', 'text/plain')
            ->withBody($factory->createStream($body));
    }
}
