<?php

namespace App\Controllers;

class PatientsMetricsController
{
    /**
     * List all metrics for a specific patient.
     *
     * @param int $patientId The ID of the patient.
     * @return string A message listing all metrics for the patient.
     */
    public function index(int $patientId): string
    {
        return "Listing all metrics for patient $patientId";
    }

    /**
     * Get a specific metric for a patient.
     *
     * @param int $patientId The ID of the patient.
     * @param string $metricId The ID of the metric.
     * @return string A message describing the specific metric.
     */
    public function get(int $patientId, string $metricId): string
    {
        return "Getting metric $metricId for patient $patientId";
    }

    /**
     * Create a new metric for a patient.
     *
     * @param int $patientId The ID of the patient.
     * @return string A message indicating metric creation.
     */
    public function create(int $patientId): string
    {
        return "Creating a metric for patient $patientId";
    }

    /**
     * Update a specific metric for a patient.
     *
     * @param int $patientId The ID of the patient.
     * @param string $metricId The ID of the metric.
     * @return string A message indicating metric update.
     */
    public function update(int $patientId, string $metricId): string
    {
        return "Updating metric $metricId for patient $patientId";
    }

    /**
     * Delete a specific metric for a patient.
     *
     * @param int $patientId The ID of the patient.
     * @param string $metricId The ID of the metric.
     * @return string A message indicating metric deletion.
     */
    public function delete(int $patientId, string $metricId): string
    {
        return "Deleting metric $metricId for patient $patientId";
    }
}
