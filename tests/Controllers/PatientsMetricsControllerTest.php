<?php

declare(strict_types=1);

namespace Tests\Controllers;

use App\Controllers\PatientsMetricsController;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PatientsMetricsControllerTest extends TestCase
{
    private PatientsMetricsController $ctrl;

    protected function setUp(): void
    {
        $this->ctrl = new PatientsMetricsController();
    }

    #[Test]
    public function index_lists_metrics_for_patient(): void
    {
        $this->assertSame(
            'Listing all metrics for patient 5',
            $this->ctrl->index(5)
        );
    }

    #[Test]
    public function get_returns_single_metric(): void
    {
        $this->assertSame(
            'Getting metric abc for patient 5',
            $this->ctrl->get(5, 'abc')
        );
    }

    #[Test]
    public function create_creates_metric(): void
    {
        $this->assertSame(
            'Creating a metric for patient 5',
            $this->ctrl->create(5)
        );
    }

    #[Test]
    public function update_updates_metric(): void
    {
        $this->assertSame(
            'Updating metric rpm for patient 5',
            $this->ctrl->update(5, 'rpm')
        );
    }

    #[Test]
    public function delete_deletes_metric(): void
    {
        $this->assertSame(
            'Deleting metric temp for patient 5',
            $this->ctrl->delete(5, 'temp')
        );
    }
}
