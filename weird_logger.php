<?php

class WeirdLogger
{
    public function info(string $message, int $code = 0): void
    {
        $log = $this->newLog($message, $code);
        $log->setSeverity($log::SEVERITY_CODE_INFO);

        $this->output($log);
    }

    public function warning(string $message, $code = 0): void
    {
        $log = $this->newLog($message, $code);
        $log->setSeverity($log::SEVERITY_CODE_WARNING);

        $this->output($log);
    }

    public function error(string $message, $code = 0): void
    {
        $log = $this->newLog($message, $code);
        $log->setSeverity($log::SEVERITY_CODE_ERROR);

        $this->output($log);
    }

    private function output($log): void
    {
        echo "{$log}" . PHP_EOL;
    }

    private function newLog(string $message, int $code)
    {
        return new class ($message, $code) {
            const SEVERITY_CODE_INFO = 0;
            const SEVERITY_CODE_WARNING = 1;
            const SEVERITY_CODE_ERROR = 2;

            const RESET_COLOR = "\033[0m";

            private $severity = self::SEVERITY_CODE_INFO;

            public function __construct(
                private string $message,
                private int $code
            ) {
            }

            public function setSeverity(int $severity)
            {
                if (!$this->severityIsValid($severity)) {
                    throw new Exception("bad!!");
                }

                $this->severity = $severity;
            }

            public function __toString(): string
            {
                return "{$this->message} {$this->getColor()}({$this->code})" .
                    self::RESET_COLOR;
            }

            private function severityIsValid(int $severity): bool
            {
                return in_array($severity, [
                    self::SEVERITY_CODE_INFO,
                    self::SEVERITY_CODE_WARNING,
                    self::SEVERITY_CODE_ERROR,
                ]);
            }

            private function getColor(): string
            {
                if ($this->severity === 0) {
                    return "\033[01;32m";
                }

                if ($this->severity === 1) {
                    return "\033[01;33m";
                }

                return "\033[01;31m";
            }
        };
    }
}

system("clear");
echo "WEIRD LOGGER DEMO" . PHP_EOL . PHP_EOL;

$logger = new WeirdLogger();

$logger->info("Looking safe");
$logger->warning("Hmmmmmm");
$logger->error("Oh sheesh!", 21);

echo PHP_EOL;
