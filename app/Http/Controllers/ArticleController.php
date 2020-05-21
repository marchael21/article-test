<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\Category;
use App\User;
use App\Models\Role;
use App\Http\Requests\StoreArticle;
use App\Http\Requests\UpdateArticle;
use Illuminate\Support\Facades\Hash; 
use Carbon\Carbon;
use Auth;



class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authId = Auth::id();

        $categoryOpt = DB::table('categories')->get();

        // Page Limit
        $pageLimit = isset($request->page_limit) ? (int)$request->page_limit : 10;

        // Query
        // $query = DB::table('articles');
        $query = Article::with('category');

        if (isset($request->id) && $request->id !=='') {
            $query->where('id', $request->id);
        }

        if (isset($request->title) && $request->title !=='') {
            $query->where('title', 'LIKE', '%'.$request->title.'%');
        }

        if (isset($request->category) && $request->category !=='') {
            $query->where('category_id', 'LIKE', '%'.$request->category.'%');
        }

        if (Auth::user()->role_id == 2) {
            $query->where('created_by', $authId);
        }

        $articles = $query->paginate($pageLimit);

        // Search Filters
        $searchFilter = array();
        $searchFilter['id'] = isset($request->id) && $request->id !== '' ? $request->id : '';
        $searchFilter['title'] = isset($request->title) && $request->title !== '' ? $request->title : '';
        $searchFilter['category'] = isset($request->category) && $request->category !== '' ? $request->category : '';
        $searchFilter['page_limit'] = $pageLimit;

        // Page Data
        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/article/list'),
                'name'  => 'Article',
                'icon'  => 'fas fa-newspaper',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'List',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.articles.list', ['articles' => $articles], compact('pageData', 'searchFilter', 'categoryOpt'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::id();
        $categoryOpt = DB::table('categories')->get();

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/article/list'),
                'name'  => 'Article',
                'icon'  => 'fas fa-newspaper',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'Create',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.articles.create', compact('pageData', 'categoryOpt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticle $request)
    {

        $authId = Auth::id();

        // Retrieve the validated input data...
        $validated = $request->validated();

        $article = new Article;
        $article->title = $request->title;
        $article->content = htmlentities($request->content);
        $article->category_id = $request->category;
        $article->visible = $request->visible;
        $article->created_by = $authId;
        $article->updated_by = $authId;

        if ($request->hasFile('image')) {
            $filename = strtolower(str_replace(' ', '_', $article->title));
            $fileExtension = $request->file('image')->guessExtension();
            request()->image->move(public_path('upload/article/images/'), $filename.'.'.$fileExtension);
            $article->image_filename = $filename.'.'.$fileExtension;
            $article->image_path = '/upload/article/images/'.$filename.'.'.$fileExtension;
        }

        try {

            // save user
            if($article->save()) {

                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'Article Created!.',
                    'text'  => 'Article has been registered successfully.',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                return redirect('article/list')->with('alertMsg', $alertMsg);
           }

        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect('article/create')->withInput()->with('alertMsg', $alertMsg);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $authId = Auth::id();

        $article = Article::find($id);

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/article/list'),
                'name'  => 'Article',
                'icon'  => 'fas fa-newspaper',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'View',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.articles.view', ['article' => $article], compact('pageData'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $authId = Auth::id();

        $article = Article::find($id);

        $categoryOpt = DB::table('categories')->get();

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/article/list'),
                'name'  => 'Article',
                'icon'  => 'fas fa-newspaper',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'Create',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.articles.edit', ['article' => $article], compact('pageData', 'categoryOpt'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticle $request, $id)
    {
        
        $authId = Auth::id();

        // Retrieve the validated input data...
        $validated = $request->validated();

        $article = Article::find($id);
        $article->title = $request->title;
        $article->content = htmlentities($request->content);
        $article->category_id = $request->category;
        $article->visible = $request->visible;
        $article->updated_by = $authId;

        if ($request->hasFile('image')) {
            $filename = strtolower(str_replace(' ', '_', $article->title));
            $fileExtension = $request->file('image')->guessExtension();
            request()->image->move(public_path('upload/article/images/'), $filename.'.'.$fileExtension);
            $article->image_filename = $filename.'.'.$fileExtension;
            $article->image_path = '/upload/article/images/'.$filename.'.'.$fileExtension;
        }

        try {

            // save user
            if($article->save()) {

                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'Article Created!.',
                    'text'  => 'Article has been updated successfully.',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                return redirect('article/list')->with('alertMsg', $alertMsg);

           }

        } catch (\Exception $e) {
            // echo $e->getMessage();
            // die;
            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect('article/create')->withInput()->with('alertMsg', $alertMsg);

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);

        try {

            $article->delete();

            $alertMsg = array(
                'title' => 'Success!',
                'text'  => 'Article "' . $article->title . '" has been deleted successfully".' ,
                'icon'  => 'success'
            );
            return redirect('/article/list')->with('alertMsg', $alertMsg);

        } catch (\Exception $e) {

            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect('/article/list')->with('alertMsg', $alertMsg);
        }
    }
}
