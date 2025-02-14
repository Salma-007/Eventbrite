<?php
namespace App\core;

class Validator {
    private array $errors = [];

    public function validate(array $data): bool {
        $requiredFields = ['titre', 'type', 'event_type', 'id_categorie', 'nombre_place', 'ville_id', 'date_event', 'date_fin', 'description'];
        
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $this->errors[$field] = "Le champ $field est requis.";
            }
        }

        if (!empty($data['description']) && strlen($data['description']) < 20) {
            $this->errors['description'] = "La description doit contenir au moins 20 caractères.";
        }

        if (!empty($data['date_event']) && !empty($data['date_fin'])) {
            if (strtotime($data['date_event']) >= strtotime($data['date_fin'])) {
                $this->errors['date_event'] = "La date de l'événement doit être avant la date de fin.";
            }
        }

        return empty($this->errors);
    }

    public function getErrors(): array {
        return $this->errors;
    }
}
