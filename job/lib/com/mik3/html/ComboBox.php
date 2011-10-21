<?php

namespace com\mik3\html {

    class ComboBox {

        static function render($name, $values, $default) {
            $buffer = '';
            $buffer .= '<select id="' . $name . '" name="' . $name . '"> ' . "\n";

            foreach ($values as $key => $value) {

                $selected = '';
                //convert numeric values to string?
                //strcmp can compare ('12',12) == 0
                if (strcmp($key, $default) == 0) {
                    $selected = "selected ";
                }
                $option = '<option value="' . $key . '"  ' . $selected . '>' . $value . '</option> ' . "\n";
                $buffer .= $option;
            }
            $buffer .= " </select> \n ";
            return $buffer;
        }

    }

}
?>
