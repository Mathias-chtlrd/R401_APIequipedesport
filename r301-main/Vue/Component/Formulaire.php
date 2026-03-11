<?php

namespace R301\Vue\Component;

class Formulaire {
    private $formulaire;
    //Constructeur
    public function __construct($returnName) {
        $this->formulaire = '<div class="container"><form action="'.$returnName.'" method=post>';
    }
    //Ajouter un text à remplir
    public function setText($description, $name, $placeholder = "", $value = "") {
        $this->formulaire .= '<div class="row">
                                <div class="col-20">
                                    <label>'.$description.'</label>
                                </div>
                                <div class="col-80">
                                    <input type=text value="'.$value.'" name="'.$name.'" placeholder="'.$placeholder.'">
                                </div>
                            </div>';
    }

    public function addHiddenInput($name, $value) {
        $this->formulaire .= '<input type=hidden value="'.$value.'" name="'.$name.'">';
    }

    public function setDate($description, $name, $value = "") {
        $this->formulaire .= '<div class="row">
                                <div class="col-20">
                                    <label>'.$description.'</label>
                                </div>
                                <div class="col-80">
                                    <input type=date value="'.$value.'" name="'.$name.'">
                                </div>
                            </div>';
    }
    public function setDateTime($description, $name, string $min = null, $value = "") {
        $this->formulaire .= "<div class=\"row\">
                                <div class=\"col-20\">
                                    <label>$description</label>
                                </div>
                                <div class=\"col-80\">
                                    <input type=\"datetime-local\" value=\"$value\" name=\"$name\" min=\"$min\">
                                </div>
                            </div>";
    }

    public function setSelect(string $description, array $values, string $name, string $SelectedValue = "") {
        $this->formulaire .= '<div class="row">
                                <div class="col-20">
                                    <label>'.$description.'</label>
                                </div>
                                <div class="col-80">
                                    <select name="'.$name.'">';
        foreach ($values as $v) {
            $this->formulaire .= "<option value=\"$v\" ".$this->addSelectedAttribute($v, $SelectedValue).">$v</option>";
        }
        $this->formulaire .= "</select>
                                </div>
                            </div>";
    }

    private function addSelectedAttribute($v, $SelectedValue) {
        if ($v == $SelectedValue) {
            return 'selected';
        }
    }

    //Ajouter un bouton
    public function addButton($type, $class, $name = "", $value = "") {
        $this->formulaire .= '<div class="row" style="margin-top:20px;">
                                <input class="'.$class.'" type="'.$type.'" value="'.$value.'" name="'.$name.'">
                            </div>';
    }

    public function addTextArea(string $name, ?string $description = null, string $value = ""){
        $this->formulaire .= '<div class="row">';
        if($description !== null) {
            $this->formulaire .= '
                <div class="col-20">
                    <label for="<?php echo $this->name; ?>"><?php echo $this->description; ?></label>
                </div>
            ';
        }
        $this->formulaire .= '
                <div><textarea name="'.$name.'">'.$value.'</textarea></div>
            ';
        $this->formulaire .= '</div>';
    }

    public function __toString() {
        return $this->formulaire."</form></div>";
    }
}