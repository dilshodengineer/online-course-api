<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use Illuminate\Support\Facades\Storage;

class CourseService
{

    public function index()
    {
        $courses = Course::latest()->get();

        return response()->json([
            'message' => 'Courses fetched successfully.',
            'data' => $courses,
        ]);
    }


    public function store(StoreCourseRequest $request)
    {
        return DB::transaction(function () use ($request) {

            $image = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image')->store('courses', 'public');
            }

            $course = Course::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $image,
                'is_published' => $request->boolean('is_published'),
            ]);

            return response()->json([
                'message' => 'Course created successfully.',
                'data' => $course,
            ], 201);
        });
    }


    public function show(string $id)
    {
        $course = Course::findOrFail($id);

        return response()->json([
            'message' => 'Course fetched successfully.',
            'data' => $course,
        ]);
    }


    public function update(UpdateCourseRequest $request, string $id)
    {
        return DB::transaction(function () use ($request, $id) {

            $course = Course::findOrFail($id);

            $image = $course->image;

            if ($request->hasFile('image')) {

                if ($course->image) {
                    Storage::disk('public')->delete($course->image);
                }

                $image = $request->file('image')->store('courses', 'public');
            }

            $course->update([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $image,
                'is_published' => $request->boolean('is_published'),
            ]);

            return response()->json([
                'message' => 'Course updated successfully.',
                'data' => $course,
            ]);
        });
    }


    public function destroy(string $id)
    {
        return DB::transaction(function () use ($id) {

            $course = Course::findOrFail($id);

            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }

            $course->delete();

            return response()->json([
                'message' => 'Course deleted successfully.',
            ]);
        });
    }
    
}
