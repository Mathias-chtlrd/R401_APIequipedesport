<?php

namespace R301\Vue\Component;

class Select {
    private array $values = [];
    private string $name;
    private ?string $description;
    private ?string $selectedValue;

    public function __construct(
        array $values,
        string $name,
        ?string $description,
        ?string $selectedValue = null
    ) {
        $this->values = $values;
        $this->name = $name;
        $this->description = $description;
        $this->selectedValue = $selectedValue;
    }

    public function toHTML() { ?>
        <div class="row">
            <?php if($this->description !== null): ?>
            <div class="col-20">
                <label for="<?php echo $this->name; ?>"><?php echo $this->description; ?></label>
            </div>
            <?php endif; ?>
            <div <?php if($this->description !== null) { echo 'class="col-80"'; } ?>>
                <select name="<?php echo $this->name; ?>">
                    <?php if($this->selectedValue === null): ?>
                    <option value="" selected></option>"
                    <?php endif; ?>
                    <?php foreach($this->values as $key => $value): ?>
                    <option value="<?php echo $key; ?>" <?php if($this->selectedValue == $value) { echo 'selected'; } ?>><?php echo $value; ?></option>";
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    <?php }
}