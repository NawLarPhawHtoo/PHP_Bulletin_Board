<?php

namespace App\Http\Controllers\Post;

use App\Contracts\Services\Post\PostServiceInterface;
use App\Exports\ExportPost;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostEditRequest;
use App\Http\Requests\PostRequest;
use App\Imports\ImportPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
    private $postInterface;

    public function __construct(PostServiceInterface $postServiceInterface)
    {
        $this->postInterface = $postServiceInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $search = $request->search;
        if ($search !== "") {
            $posts = Post::where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%');
            })->orderBy('id', 'DESC')->paginate(5);
            $posts->appends(['search' => $search]);
        } else {
            $posts = $this->postInterface->show();
        }
        return view('posts.index', compact('posts'));
    }

    /**
     * Show form for creating a new post
     */
    public function create()
    {
        return view('posts.create');
    }

    // public function submitPostCreateView(PostRequest $request)
    // {
    //     // validation for request values
    //     $validated = $request->validated();

    //     return redirect()
    //         ->route('posts.create')
    //         ->withInput();
    // }

    /**
     * To show post create confirm view
     *
     * @return View post create confirm view
     */
    // public function showPostCreateConfirmView()
    // {
    //     if (old()) {
    //         return view('posts.create-confirm');
    //     }
    //     return redirect()->route('posts.index');
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $this->postInterface->store($request);
        return redirect()->route('posts.search')->with('success', 'Post has been created successfully.');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $post = $this->postInterface->show($request);
        return view('posts.detail', compact('post'));
    }

    public function edit($id)
    {
        $post = $this->postInterface->detail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostEditRequest $request, $id)
    {
        $this->postInterface->update($request, $id);
        return redirect()->route('posts.search')->with('success', 'Post has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->postInterface->delete($id);
        return redirect()->route('posts.search')->with('success', 'Post has been deleted successfully.');
    }

    public function upload()
    {
        return view('posts.upload');
    }

    public function importExcel(Request $request)
    {
        $file = $request->file('file')->store('import');
        $import = new ImportPost;
        $import->import($file);
        if($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }
        return back()->withStatus('Post imported successfully');
    }

    public function export()
    {
        return Excel::download(new ExportPost, 'posts.xlsx');
    }
}
