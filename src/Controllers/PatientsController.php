<?php

namespace App\Controllers;

class PatientsController
{
    public function index()
    {
        return "Listing all patients";
    }

    public function get($patientId)
    {
        return "Getting patient with ID: $patientId";
    }

    public function create()
    {
        return "Creating a new patient";
    }

    public function update($patientId)
    {
        return "Updating patient with ID: $patientId";
    }

    public function delete($patientId)
    {
        return "Deleting patient with ID: $patientId";
    }
}
