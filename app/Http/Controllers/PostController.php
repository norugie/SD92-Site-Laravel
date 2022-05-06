<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Link;
use App\Models\Category;
use App\Http\Controllers\FileUploadController;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct ()
    {
        $this->file = new FileUploadController;
    }

    // Posts
    public function postsPostsIndex ()
    {
        $posts = Post::all()->sortByDesc('id');

        return view ( 'cms.posts.posts', compact('posts'));
    }

    public function postsCreateNewPostPage ()
    {
        $categories = Category::where('cat_status', 'Active')->get();

        return view ( 'cms.posts.create.posts', compact('categories'));
    }

    public function postsCreateNewPost (Request $request)
    {
        // Validate content
        $request->validate( 
            [
                'post_title' => 'required'
            ],
            [
                'post_title.required' => 'This field is required.'
            ]
        );

        $post = new Post;

        // Post content
        $post->post_slug = "PST" . rand(1111111111,9999999999);
        $post->post_title = $request->post_title;
        $post->post_type = $request->post_opt_type;
        $post->post_desc = $request->post_desc;
        $post->post_content = $request->post_content;
        $post->post_social = $request->post_sm_autopost;
        $post->post_ssd = $request->post_ssd_autopost;
        $post->post_ss = $request->post_ss_autopost;
        $post->post_gcc = $request->post_gcc_autopost;
        $post->post_nlc = $request->post_nlc_autopost;

        // Post author
        $post->user_id = session('userID');
        $post->department_id = session('schoolToPost');

        // Post thumbnail
        $post_thumbnail = $this->file->uploadImage($request->file('post_thumbnail'), 'thumbnail');
        echo $post_thumbnail;
        // $post->save();
    
        // // Post categories
        // $categories = explode(',', $request->post_categories_id);
        // $post->categories()->attach($categories);

        // echo $post->id . "<br>";
        // var_dump($categories);
        // dd($post);
    }

    // Categories
    public function postsCategoriesIndex ()
    {
        return view ( 'cms.posts.categories' );
    }

    // Links
    public function postsLinksIndex ()
    {
        return view ( 'cms.posts.links' );
    }
}
