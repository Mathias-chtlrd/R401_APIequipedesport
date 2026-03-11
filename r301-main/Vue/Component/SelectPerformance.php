<?php

namespace R301\Vue\Component;

use R301\Modele\Participation\Performance;

class SelectPerformance extends Select {

    public function __construct(
            ?string $description,
            ?string $selectedValue = null
    ) {
        $values = [];
        foreach (Performance::cases() as $performance) {
            $values[$performance->name] = $performance->name;
        }

        parent::__construct($values, "performance", $description, $selectedValue);
    }
}