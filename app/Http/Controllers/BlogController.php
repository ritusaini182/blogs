<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blogs;
use Session;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\Helper;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use URL;
use DB;

class BlogController extends Controller
{
    /**
     * Blogs list
     */
    public function blogList(Request $request)
    {
        if (request()->ajax()) {
            $blogs = Blogs::all();
            return Datatables()->of($blogs)
                ->addIndexColumn()
                ->editColumn('description', function ($blogs) {
                    $split = explode(" ", $blogs->description);
                    $description = implode(" ", array_splice($split, 0, 100));
                    return $description;
                })
                ->addColumn('image', function ($blogs) {
                    $urlImg = asset("public/blogs/$blogs->image");
                    return  '<a target="_blank" href=' . $urlImg . '><img src=' . $urlImg . ' border="0" width="40" class="img-rounded" align="center" /></a>';
                })
                ->addColumn('tags', function ($blogs) {
                    $tags = DB::table('tagging_tagged')->where('taggable_id',$blogs->id)->first();
                    $name = $tags->tag_name;
                    $tag= '<span class="btn btn-sm btn-info">'.$name.'</span>';
                    return $tag;
                })
                ->addColumn('action', function ($blogs) {
                    $id = Helper::encodeID($blogs->id);
                    $url = config('app.url');
                    $userId = Auth()->id();
                    if ($userId == $blogs->created_by) {
                        $editBtn = '<a href="' .  $url . '/blogs/edit/' . $id . '" class="btn btn-sm btn-info">Edit</a>';
                        $deleteBTn = '<a href="#" class="btn btn-sm btn-danger DeleteBtn" id="deleteBtn" data-href =' . $id . '>Delete</a>';
                        return  $editBtn . ' ' . $deleteBTn;
                    } else {
                        return '---';
                    }
                })
                ->rawColumns(['image', 'action','tags'])
                ->make(true);
        }
        return view('blogs.list');
    }

    /**
     * Add blogs
     */
    public function blogAdd()
    {
        return view('blogs.add');
    }

    /**
     * save blog details
     */
    public function blogSave(Request $request)
    {
        /**validate blog fields */
        $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:65535'],
            'image' => ['required', 'max:100'],
            'tags' => ['required']
        ]);

        /**uplaod blog image */
        if ($request->has('image')) {
            $file = $request->file("image");
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file_path = public_path('blogs');
            $file->move($file_path, $filename);
            $request['image'] = $filename;
        }
        
        // /**Create blogs */
        
        $input = $request->all();
    	$tags = explode(",", $request->tags);
    	$blogs = Blogs::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $filename,
            'tags' => $request->tags,
            'created_by' => Auth()->id()
        ]);
    	$blogs->tag($tags);
        Session::flash('message_update', 'Blog created successfully!');
        return redirect()->route('blogs');
    }

    /**
     * edit blogs
     */
    public function blogEdit($id)
    {
        $id = Helper::decodeID($id);
        $blogs = Blogs::find($id);
        $imgurl = URL::to('public/blogs/' . $blogs->image);
        $tags = DB::table('tagging_tagged')->where('taggable_id',$id)->first();
        return view('blogs.edit', compact('blogs', 'imgurl','tags'));
    }

    /**
     * Update Blogs
     */
    public function blogUpdate(Request $request)
    {
        /**validate blog fields */
        $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:65535'],
            'tags' => ['required']
        ]);

        /**Update new image if uploaded */
        if ($request->image != null) {
            $file = $request->file("image");
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file_path = public_path('blogs');
            $file->move($file_path, $filename);
            $request['image'] = $filename;
        } else {
            $filename = $request->old_iamge;
        }

        /**UPdate blogs data */
        $blogs = Blogs::find($request->id);
        $blogs->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $filename,
        ]);
        $tags = DB::table('tagging_tagged')->where('taggable_id', (int)$request->id)->update(array('tag_name' => $request->tags));
        Session::flash('message_update', 'Blog Updated successfully!');
        return redirect()->route('blogs');
    }

    /**
     * destroy blog
     */
    public function blogDelete(Request $request)
    {
        $id = Helper::decodeID($request->bid);
        $blogs = Blogs::find($id)->delete();
        return true;
    }
}
