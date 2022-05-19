<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index() {
      return view('pages.index');
    }
    
    public function list(Request $request) {
      $model = Task::get();

      return json_encode(['data' => $model]);
    }

    public function create(Request $request) {
      if (empty($request->name)) {
        return json_encode(['error' => 1, 'message' => \Lang::get('translation.TaskName').\Lang::get('translation.Required')]);
      } else if (empty($request->priority)) {
        return json_encode(['error' => 1, 'message' => \Lang::get('translation.Priority').\Lang::get('translation.Required')]);
      }

      $model = new Task;
      $model->name = $request->name;
      $model->priority = $request->priority;
      if ($model->save()) {
        return json_encode(['error' => 0, 'message' => \Lang::get('translation.SuccessSave')]);
      }

      return json_encode(['error' => 1, 'message' => \Lang::get('translation.FailedSave')]);
    }

    public function update(Request $request, $id) {
      if (empty($request->name)) {
        return json_encode(['error' => 1, 'message' => \Lang::get('translation.TaskName').\Lang::get('translation.Required')]);
      } else if (empty($request->priority)) {
        return json_encode(['error' => 1, 'message' => \Lang::get('translation.Priority').\Lang::get('translation.Required')]);
      }

      $model = Task::where('id', $id)->first();
      if ($model) {
        $model->name = $request->name;
        $model->priority = $request->priority;
        if ($model->save()) {
          return json_encode(['error' => 0, 'message' => \Lang::get('translation.SuccessUpdate')]);
        }
      }

      return json_encode(['error' => 1, 'message' => \Lang::get('translation.FailedUpdate')]);
    }

    public function delete(Request $request, $id) {

      $model = Task::where('id', $id);
      if ($model->delete()) {
        return json_encode(['error' => 0, 'message' => \Lang::get('translation.SuccessDelete')]);
      }

      return json_encode(['error' => 1, 'message' => \Lang::get('translation.FailedDelete')]);
    }

}
