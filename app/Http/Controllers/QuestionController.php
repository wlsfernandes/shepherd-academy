<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $testId = $question->test_id;
        $question->delete(); // This should only delete the question
        return redirect()
            ->route('test.edit', $testId)
            ->with('success', 'Question deleted successfully.');
    }
}
