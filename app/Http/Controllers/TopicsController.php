<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Handlers\ImageUploadHandler;
use Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{
		//$topics = Topic::with('user','category')->paginate();
		$topics = $topic->withOrder($request->order)->paginate();
		return view('topics.index', compact('topics'));

	}

    public function show(Topic $topic)
    {

        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
		$categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request ,Topic $topic)
	{

		$topic->fill($request->all());
		$topic->user_id = Auth::id();
		$topic->save();
		return redirect()->to($topic->link())->with('message', '添加成功');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		$categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('message', '修改成功');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', '删除成功');
	}


	public function uploadImage(Request $request,ImageUploadHandler $uploadHandler )
	{

		//初始化数组 默认失败
		$data = [
			'success'   => false,
			'msg'       => '上传失败!',
			'file_path' => ''
		];

		if($request->upload_file){

			$result = $uploadHandler->save($request->upload_file, 'topics', Auth::id(), 1024);

			if($result){

				$data = [
					'success'   => true,
					'msg'       => '上传成功!',
					'file_path' => $result['path']
				];

			}

		}

		return $data;

	}
}