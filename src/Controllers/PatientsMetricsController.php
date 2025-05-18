<?php

namespace App\Controllers;

class PatientsMetricsController
{
    public function index($patientId): string
    {
        return "Listing all metrics for patient $patientId";
    }

    public function get($patientId, $metricId): string
    {
        return "Getting metric $metricId for patient $patientId";
    }

    public function create($patientId): string
    {
        return "Creating a metric for patient $patientId";
    }

    public function update($patientId, $metricId): string
    {
        return "Updating metric $metricId for patient $patientId";
    }

    public function delete($patientId, $metricId): string
    {
        return "Deleting metric $metricId for patient $patientId";
    }
}
