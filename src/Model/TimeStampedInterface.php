<?php

namespace App\Model;

interface TimeStampedInterface
{
    public function getCreatedAt(): ?\DateTime;

    public function setCreatedAt(?\DateTime $createdAt): void;

    public function getUpdatedAt(): ?\DateTime;

    public function setUpdatedAt(?\DateTime $updatedAt): void;
}