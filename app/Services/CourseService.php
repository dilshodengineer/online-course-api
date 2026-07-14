<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Course\StoreCourseRequest;

class CourseService {

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
                'course' => $course,
            ], 201);
        });
    }
    
}