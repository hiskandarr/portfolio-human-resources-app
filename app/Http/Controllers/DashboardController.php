<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Presence;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Employee::count();
        $department = Department::count();
        $payroll = Payroll::count();
        $presence = Presence::count();

        $tasks = Task::all();

        return view('dashboard.index', compact('employee', 'department', 'payroll', 'presence', 'tasks'));
    }

    public function chartPresence()
    {

        $driver = DB::connection()->getDriverName();

        if ($driver == 'sqlite') {
            $data = Presence::where('status', 'present')
                ->selectRaw("strftime('%m', date) as month, strftime('%Y', date) as year, COUNT(*) as total_present")
                ->groupBy('year', 'month')
                ->orderBy('month', 'asc') // Jan, Feb, Mar, ..
                ->get();
        } else {
            $data = Presence::where('status', 'present')
                ->selectRaw('MONTH(date) as month, YEAR(date) as year, COUNT(*) as total_present')
                ->groupBy('year', 'month')
                ->orderBy('month', 'asc') // Jan, Feb, Mar, ..
                ->get();
        }

        $temp = [];
        $i = 0;

        // Contoh yang diinginkan : [5, 10, 15, 20, 25, 30]

        foreach ($data as $item) {
            $temp[$i] = $item->total_present;

            $i++;
        }

        return response()->json($temp);
    }
}
