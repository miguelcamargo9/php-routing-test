<?php
declare(strict_types=1);

namespace Tests\Controllers;

use App\Controllers\PatientsController;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PatientsControllerTest extends TestCase
{
    private PatientsController $ctrl;

    protected function setUp(): void
    {
        $this->ctrl = new PatientsController();
    }

    #[Test]
    public function index_lists_all_patients(): void
    {
        $this->assertSame(
            'Listing all patients',
            $this->ctrl->index()
        );
    }

    #[Test]
    public function get_returns_single_patient(): void
    {
        $this->assertSame(
            'Getting patient with ID: 3',
            $this->ctrl->get(3)
        );
    }

    #[Test]
    public function create_creates_patient(): void
    {
        $this->assertSame(
            'Creating a new patient',
            $this->ctrl->create()
        );
    }

    #[Test]
    public function update_updates_patient(): void
    {
        $this->assertSame(
            'Updating patient with ID: 7',
            $this->ctrl->update(7)
        );
    }

    #[Test]
    public function delete_deletes_patient(): void
    {
        $this->assertSame(
            'Deleting patient with ID: 10',
            $this->ctrl->delete(10)
        );
    }
}
