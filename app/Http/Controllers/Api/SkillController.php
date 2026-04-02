<?php
// app/Http/Controllers/Api/SkillController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // Public — anyone can view
    public function index()
    {
        $skills = Skill::orderBy('category')->orderBy('order')->get();
        return response()->json(['status' => true, 'data' => $skills]);
    }

    // Admin only
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'percentage' => 'required|integer|min:0|max:100',
            'category' => 'required|string|max:100',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $skill = Skill::create($request->all());
        return response()->json(['status' => true, 'data' => $skill], 201);
    }

    public function show(Skill $skill)
    {
        return response()->json(['status' => true, 'data' => $skill]);
    }

    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'sometimes|string|max:100',
            'percentage' => 'sometimes|integer|min:0|max:100',
            'category' => 'sometimes|string|max:100',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $skill->update($request->all());
        return response()->json(['status' => true, 'data' => $skill]);
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return response()->json(['status' => true, 'message' => 'Skill deleted.']);
    }
}