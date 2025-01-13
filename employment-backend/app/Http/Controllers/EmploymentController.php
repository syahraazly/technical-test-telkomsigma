<?php

namespace App\Http\Controllers;

use App\Models\Employment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmploymentController extends Controller
{
    // GET /employments
    public function index(Request $request)
    {
        $query = Employment::query();

        // hanya tampilkan data yang belum dihapus
        $query->where('is_deleted', false);

        // pencarian dan filter lainnya
        if ($request->has('search') && $request->search !== null) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('gender', 'like', "%$search%")
                    ->orWhere('role', 'like', "%$search%")
                    ->orWhere('job_grade', 'like', "%$search%")
                    ->orWhere('employment_no', 'like', "%$search%")
                    ->orWhere('employment_status', 'like', "%$search%")
                    ->orWhere('manager', 'like', "%$search%");
            });
        }

        // filter berdasarkan employment_status
        if ($request->has('employment_status') && $request->employment_status !== null) {
            $query->where('employment_status', $request->employment_status);
        }

        // mengurutkan berdasarkan last update
        $query->orderBy('updated_at', 'desc');

        // get employment
        $employments = $query->get();

        return response()->json($employments);
    }

    // GET /employments/{id}
    public function show($id)
    {
        $employment = Employment::find($id);

        if (!$employment) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return response()->json($employment);
    }

    // POST /employments
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'gender' => 'required|in:' . implode(',', Employment::$genderEnum),
            'role' => 'required|string',
            'job_grade' => 'required|in:' . implode(',', Employment::$jobGradeEnum),
            'employment_no' => 'required|string|unique:employments',
            'employment_status' => 'required|in:' . implode(',', Employment::$employmentStatusEnum),
            'manager' => 'required|string',
            'join_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        $employment = Employment::create($validated);

        return response()->json($employment, 201);
    }

    // PUT /employments/{id}
    public function update(Request $request, $id)
    {
        $employment = Employment::find($id);

        if (!$employment) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'gender' => 'required|in:' . implode(',', Employment::$genderEnum),
            'role' => 'required|string',
            'job_grade' => 'required|in:' . implode(',', Employment::$jobGradeEnum),
            'employment_status' => 'required|in:' . implode(',', Employment::$employmentStatusEnum),
            'manager' => 'required|string',
            'join_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        // update data lokal
        $employment->update($validated);

        return response()->json($employment, 200);
    }

    // DELETE /employments/{id}
    public function destroy($id)
    {
        $employment = Employment::find($id);

        if (!$employment) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $updated = $employment->update(['is_deleted' => true]);

        if (!$updated) {
            return response()->json(['message' => 'Failed to update data'], 500);
        }

        return response()->json(['message' => 'Data deleted successfully']);
    }

    // GET /employments/count-by-category
    public function countByCategory(Request $request)
    {
        $query = Employment::select('employment_status', DB::raw('count(*) as total'))
        ->groupBy('employment_status');

        // filter berdasarkan tanggal 
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('join_date', [$request->start_date, $request->end_date]);
        }

        $counts = $query->get();

        return response()->json($counts);
    }

    // GET /employments/aggregation-by-date
    public function aggregationByDate(Request $request)
    {
        $query = Employment::select(DB::raw('DATE(join_date) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc');

        // filter berdasarkan tanggal 
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('join_date', [$request->start_date, $request->end_date]);
        }

        $aggregation = $query->get();

        return response()->json($aggregation);
    }

    // GET /employments/charts-data
    public function getChartsData(Request $request)
    {
        // Query untuk Pie Chart (count by category)
        $categoryQuery = Employment::select('employment_status', DB::raw('count(*) as total'))
            ->groupBy('employment_status');

        // Query untuk Column Chart (aggregation by date)
        $dateQuery = Employment::select(DB::raw('DATE(join_date) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc');

        // Tambahkan filter tanggal jika ada
        if ($request->has('start_date') && $request->has('end_date')) {
            $categoryQuery->whereBetween('join_date', [$request->start_date, $request->end_date]);
            $dateQuery->whereBetween('join_date', [$request->start_date, $request->end_date]);
        }

        // Eksekusi query
        $categoryData = $categoryQuery->get();
        $dateData = $dateQuery->get();

        // Return data dalam satu respons
        return response()->json([
            'categoryData' => $categoryData,
            'dateData' => $dateData,
        ]);
    }

}
