<?php

namespace App\Controllers;

class PatientsController
{
    /**
     * List all patients.
     *
     * @return string A message listing all patients.
     */
    public function index(): string
    {
        return "Listing all patients";
    }

    /**
     * Get a specific patient by ID.
     *
     * @param int $patientId The ID of the patient.
     * @return string A message describing the patient.
     */
    public function get(int $patientId): string
    {
        return "Getting patient with ID: $patientId";
    }

    /**
     * Create a new patient.
     *
     * @return string A message indicating patient creation.
     */
    public function create(): string
    {
        return "Creating a new patient";
    }

    /**
     * Update a specific patient by ID.
     *
     * @param int $patientId The ID of the patient.
     * @return string A message indicating patient update.
     */
    public function update(int $patientId): string
    {
        return "Updating patient with ID: $patientId";
    }

    /**
     * Delete a specific patient by ID.
     *
     * @param int $patientId The ID of the patient.
     * @return string A message indicating patient deletion.
     */
    public function delete(int $patientId): string
    {
        return "Deleting patient with ID: $patientId";
    }
}
