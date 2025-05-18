<?php

namespace App\Controllers;

class PatientsController
{
    public function index(): string
    {
        return "Listing all patients";
    }

    public function get($patientId): string
    {
        return "Getting patient with ID: $patientId";
    }

    public function create(): string
    {
        return "Creating a new patient";
    }

    public function update($patientId): string
    {
        return "Updating patient with ID: $patientId";
    }

    public function delete($patientId): string
    {
        return "Deleting patient with ID: $patientId";
    }
}
