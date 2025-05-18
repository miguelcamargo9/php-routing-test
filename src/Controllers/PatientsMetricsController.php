<?php

namespace App\Controllers;

class PatientsMetricsController
{
    public function index($patientId)
    {
        return "Listing all metrics for patient $patientId";
    }

    public function get($patientId, $metricId)
    {
        return "Getting metric $metricId for patient $patientId";
    }

    public function create($patientId)
    {
        return "Creating a metric for patient $patientId";
    }

    public function update($patientId, $metricId)
    {
        return "Updating metric $metricId for patient $patientId";
    }

    public function delete($patientId, $metricId)
    {
        return "Deleting metric $metricId for patient $patientId";
    }
}
