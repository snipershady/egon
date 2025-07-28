<?php

namespace Egon\Dto\ResponseValidationV4;

class ValidationV4QualityField {

    private ?string $flag = null;
    private ?string $code = null;
    private ?string $description = null;

    public function getFlag(): string {
        return $this->flag;
    }

    public function getCode(): string {
        return $this->code;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setFlag(string $flag): static {
        $this->flag = $flag;
        return $this;
    }

    public function setCode(string $code): static {
        $this->code = $code;
        return $this;
    }

    public function setDescription(string $description): static {
        $this->description = $description;
        return $this;
    }
}
