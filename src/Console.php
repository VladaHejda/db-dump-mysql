<?php

namespace Dogma\Tools;

use Dogma\Tools\Dumper\System;

class Console
{

    public function write(...$params): self
    {
        foreach ($params as $param) {
            echo $param;
        }
        return $this;
    }

    public function writeLn(...$params): self
    {
        foreach ($params as $param) {
            echo $param;
        }

        $this->ln();

        return $this;
    }

    public function ln($rows = 1): self
    {
        if ($rows === 1) {
            echo "\n";
        } else {
            echo str_repeat("\n", $rows);
        }
        return $this;
    }

    public function writeFile(string $fileName): self
    {
        echo file_get_contents($fileName);

        return $this;
    }

    public static function switchTerminalToUtf8()
    {
        if (System::isWindows()) {
            exec('chcp 65001');
        }
    }

    public static function getTerminalWidth(): int
    {
        static $columns;

        if ($columns) {
            return $columns;
        }

        if (System::isWindows()) {
            exec('mode CON', $output);
            list(, $columns) = explode(':', $output[4]);
            $columns = (int) trim($columns);
        } else {
            $columns = (int) exec('/usr/bin/env tput cols');
        }

        if (!$columns) {
            $columns = 80;
        }

        return $columns;
    }

}
