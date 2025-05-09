<?php

namespace Controllers;

class HTMLGenerator
{
    static public function select(string $name, array $allValues, int $idSelectedValue, array $params = []): string
    {
        $champs = '';

        // Générer les classes
        foreach ($params as $key => $value) {
            $champs .= htmlspecialchars($key) . '="' . htmlspecialchars($value) . '" ';
        }

        // Générer le select
        $select = '<select class="form-select" name="' . htmlspecialchars($name) . '" id="' . htmlspecialchars($name) . '" ' . trim($champs) . '>' . "\r
        <option selected disabled>Sélectionnez une localité</option>
        ";
        foreach ($allValues as $value) {
            $select .= '<option value="' . htmlspecialchars($value["id"]) . '"' . ($idSelectedValue == $value["id"] ? ' selected' : '') . '>' . htmlspecialchars($value["nom"]) . '</option>' . "\r";
        }
        $select .= '</select>';
        return $select;
    }

    static public function checkboxes(string $name, array $allValues, array $idsSelectedValue): string
    {
        $checkboxes = '';
        foreach ($allValues as $value) {
            $checkboxes .= '<div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"' . (in_array($value["id"], $idsSelectedValue) ? ' checked' : '') . '
                            name="' . $name . '"
                            id="' . $value['nom'] . '"
                            value="' . $value['id'] . '">
                        <label class="form-check-label" for="' . $value['nom'] . '">' . $value['nom'] . '</label>
                    </div>';
        }
        return $checkboxes;
    }
}
