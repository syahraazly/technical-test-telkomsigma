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

        // pencarian untuk semua kolom
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

        // pengecekan khusus untuk `employment_no`, hanya diizinkan diubah jika baru
        if ($request->has('employment_no') && $request->employment_no !== Employment::findOrFail($id)->employment_no) {
            // menghapus `employment_no` dari data input, karena tidak boleh diubah
            unset($validated['employment_no']);
        }

        // menemukan data employment berdasarkan ID
        $employment = Employment::findOrFail($id);

        // update data employment kecuali `employment_no`
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

        $employment->delete();

        return response()->json(['message' => 'Data deleted successfully']);
    }

}
