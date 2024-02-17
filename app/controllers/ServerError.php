<?php

namespace Controller;

class ServerError extends \Core\BaseController
{
    public function __construct(int $code, string $error, string $description, ?string $log = null)
    {
        $this->code         = $code;
        $this->error        = $error;
        $this->description  = $description;
        $this->log          = $log;
    }

    protected function main()
    {
        $this->setData([
            "error"       => $this->error,
            "description" => $this->description,
            "log"         => $this->log
        ]);

        $this->setView("server_error");
        http_response_code($this->code);
    }

    public function init()
    {
        $this->main();
        $this->render();
    }
}