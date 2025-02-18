<?php declare(strict_types = 1);

namespace Adbros\Tester\ControllerTester;

use Contributte\Psr7\Psr7UploadedFile;
use Nette\SmartObject;
use Nette\Utils\Json;

class TestControllerRequest
{

	use SmartObject;

	/**	@var string */
	private $uri;

	/**	@var mixed[] */
	private $parameters = [];

	/** @var string */
	private $method = 'GET';

	/** @var string|null */
	private $rawBody;

	/** @var mixed[] */
	private $headers = [];

	/** @var string */
	private $protocolVersion = '1.1';

	/** @var mixed[] */
	private $serverParams = [];

	/** @var array<string, Psr7UploadedFile> */
	private $files = [];

	public function __construct(string $uri)
	{
		$this->uri = $uri;
	}

	public function getUri(): string
	{
		return $this->uri;
	}

	/**
	 * @return mixed[]
	 */
	public function getParameters(): array
	{
		return $this->parameters;
	}

	public function getMethod(): string
	{
		return $this->method;
	}

	public function getRawBody(): ?string
	{
		return $this->rawBody;
	}

	/**
	 * @return mixed[]
	 */
	public function getHeaders(): array
	{
		return $this->headers;
	}

	public function getProtocolVersion(): string
	{
		return $this->protocolVersion;
	}

	/**
	 * @return mixed[]
	 */
	public function getServerParams(): array
	{
		return $this->serverParams;
	}

	/**
	 * @return Psr7UploadedFile[]
	 */
	public function getFiles(): array
	{
		return $this->files;
	}

	/**
	 * @param mixed[] $parameters
	 */
	public function withParameters(array $parameters): TestControllerRequest
	{
		$request = clone $this;
		$request->parameters = $parameters + $request->parameters;

		return $request;
	}

	public function withMethod(string $method): TestControllerRequest
	{
		$request = clone $this;
		$request->method = $method;

		return $request;
	}

	public function withRawBody(string $body): TestControllerRequest
	{
		$request = clone $this;
		$request->rawBody = $body;

		return $request;
	}

	/**
	 * @param mixed[] $body
	 */
	public function withJsonBody(array $body): TestControllerRequest
	{
		$request = clone $this;
		$request->rawBody = Json::encode($body);

		return $request;
	}

	/**
	 * @param mixed[] $headers
	 */
	public function withHeaders(array $headers): TestControllerRequest
	{
		$request = clone $this;
		$request->headers = array_change_key_case($headers, CASE_LOWER) + $request->headers;

		return $request;
	}

	public function withProtocolVersion(string $protocolVersion): TestControllerRequest
	{
		$request = clone $this;
		$request->protocolVersion = $protocolVersion;

		return $request;
	}

	/**
	 * @param mixed[] $serverParams
	 */
	public function withServerParams(array $serverParams): TestControllerRequest
	{
		$request = clone $this;
		$request->serverParams = array_change_key_case($serverParams, CASE_UPPER) + $request->serverParams;

		return $request;
	}

	public function withFile(string $name, string $filePath): TestControllerRequest
	{
		$request  = clone $this;
		$filesize = is_file($filePath) ? filesize($filePath) : false;
		$size = $filesize === false ? 0 : $filesize;
		$status = $filesize === false ? UPLOAD_ERR_NO_FILE : UPLOAD_ERR_OK;
		$request->files[$name] = new Psr7UploadedFile($filePath, $size, $status);

		return $request;
	}

}
