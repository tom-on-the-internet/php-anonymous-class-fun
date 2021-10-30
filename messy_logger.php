<?php

class MessyLogger
{
    const SEVERITY_CODE_INFO = 0;
    const SEVERITY_CODE_WARNING = 1;
    const SEVERITY_CODE_ERROR = 2;

    public function info(string $message, int $code = 0): void
    {
        $this->output($message, $code, self::SEVERITY_CODE_INFO);
    }

    public function warning(string $message, int $code = 0): void
    {
        $this->output($message, $code, self::SEVERITY_CODE_WARNING);
    }

    public function error(string $message, int $code = 0): void
    {
        $this->output($message, $code, self::SEVERITY_CODE_ERROR);
    }

    private function output(string $message, int $code, int $severity): void
    {
        $resetColor = "\033[0m";
        $color = $this->getColor($severity);

        echo "{$message} {$color}({$code}){$resetColor}" . PHP_EOL;
    }

    private function getColor(int $severity): string
    {
        if ($severity === 0) {
            return "\033[01;32m";
        }

        if ($severity === 1) {
            return "\033[01;33m";
        }

        return "\033[01;31m";
    }
}

system("clear");
echo "MESSY LOGGER DEMO" . PHP_EOL . PHP_EOL;

$logger = new MessyLogger();

$logger->info("Looking safe");
$logger->warning("Hmmmmmm");
$logger->error("Oh sheesh!", 21);

echo PHP_EOL;
