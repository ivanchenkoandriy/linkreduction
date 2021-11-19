<?php

namespace app\models;

interface CommandInterface
{
    public function execute(): bool;
}
